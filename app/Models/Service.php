<?php

namespace App\Models;

use App\Classes\Price;
use App\Classes\Settings;
use App\Models\Traits\HasProperties;
use App\Observers\ServiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([ServiceObserver::class])]
class Service extends Model implements Auditable
{
    use HasFactory, HasProperties, Traits\Auditable;

    public const STATUS_PENDING = 'pending';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'order_id',
        'product_id',
        'plan_id',
        'quantity',
        'price',
        'expires_at',
        'subscription_id',
        'status',
        'provisioning_status',
        'provisioning_error',
        'coupon_id',
        'user_id',
        'currency_code',
        'billing_agreement_id',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'code', 'currency_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => new Price(['price' => $this->price * $this->quantity, 'currency' => $this->currency])
        );
    }

    public function label(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: $this->baseLabel
        );
    }

    public function baseLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->product->name . ' #' . $this->id
        );
    }

    public function description(): Attribute
    {
        if ($this->plan->type == 'free' || $this->plan->type == 'one-time') {
            return Attribute::make(
                get: fn () => $this->product->name
            );
        }
        $date = $this->expires_at ?? now();
        $endDate = $date->copy()->{'add' . ucfirst($this->plan->billing_unit) . 's'}($this->plan->billing_period);

        return Attribute::make(
            get: fn () => $this->product->name . ' (' . $date->format('M d, Y') . ' - ' . $endDate->format('M d, Y') . ')'
        );
    }

    public function calculateNextDueDate()
    {
        if ($this->plan->type == 'one-time' || $this->plan->type == 'free') {
            return null;
        }
        if (!$this->expires_at || $this->status != self::STATUS_ACTIVE) {
            $date = now();
        } else {
            $date = $this->expires_at;
        }

        return $date->{'add' . ucfirst($this->plan->billing_unit) . 's'}($this->plan->billing_period);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function configs()
    {
        return $this->morphMany(ServiceConfig::class, 'configurable');
    }

    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'reference');
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, InvoiceItem::class, 'reference_id', 'id', 'id', 'invoice_id')->where('reference_type', Service::class);
    }

    public function cancellation()
    {
        return $this->hasOne(ServiceCancellation::class);
    }

    public function cancellable(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status !== 'cancelled' && $this->plan->type != 'free' && $this->plan->type != 'one-time' && !$this->cancellation?->exists()
        );
    }

    public function upgradable(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->productUpgrades()->count() > 0 || $this->product->upgradableConfigOptions()->count() > 0) && $this->status == 'active' && $this->upgrade->where('status', ServiceUpgrade::STATUS_PENDING)->count() == 0
        );
    }

    public function productUpgrades()
    {
        return $this->product->upgrades->filter(function ($product) {
            if ($product->stock !== null && ($product->stock - $this->quantity) < 0) {
                return null;
            }
            $plan = $product->plans()->where('billing_unit', $this->plan->billing_unit)->where('billing_period', $this->plan->billing_period)->get();
            if ($plan->count() > 0) {
                $product->plan = $plan->first();

                return $product;
            }

            return null;
        });
    }

    public function calculatePrice()
    {
        $price = $this->plan->price($this->currency_code)->price;

        $this->configs->each(function ($config) use (&$price) {
            $configValue = $config->configValue;
            if ($configValue) {
                $price += $configValue->price(null, $this->plan->billing_period, $this->plan->billing_unit, $this->currency_code)->price;
            }
        });

        if ($this->coupon) {
            $invoices = $this->invoices()->where('status', 'paid')->count() + 1;
            if ($this->coupon->recurring == 0 || $invoices <= $this->coupon->recurring) {
                $discount = $this->coupon->calculateDiscount($price);
                $price -= $discount;
            }
        }

        $price = (new Price([
            'price' => $price,
            'currency' => $this->currency,
        ], apply_exclusive_tax: true, tax: Settings::tax($this->user)))->price;

        return number_format($price, 2, '.', '');
    }

    public function upgrade()
    {
        return $this->hasMany(ServiceUpgrade::class);
    }

    public function billingAgreement()
    {
        return $this->belongsTo(BillingAgreement::class, 'billing_agreement_id');
    }
}
