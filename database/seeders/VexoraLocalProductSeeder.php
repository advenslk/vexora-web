<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Price;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VexoraLocalProductSeeder extends Seeder
{
    public function run(): void
    {
        Currency::updateOrCreate(
            ['code' => 'INR'],
            ['name' => 'Indian Rupee', 'prefix' => '₹', 'suffix' => '', 'format' => '1,000.00'],
        );

        Setting::updateOrCreate(
            ['key' => 'default_currency'],
            ['value' => 'INR', 'type' => 'string'],
        );

        $categories = [
            [
                'slug' => 'budget-game-hosting',
                'name' => 'Budget Game Hosting',
                'description' => 'India Intel Xeon game server hosting.',
                'plans' => [
                    ['Nano', 40, '2GB DDR4 RAM / 75% CPU / 15GB NVMe SSD'],
                    ['Starter', 70, '4GB DDR4 RAM / 125% CPU / 25GB NVMe SSD'],
                    ['Performance', 120, '6GB DDR4 RAM / 175% CPU / 35GB NVMe SSD'],
                    ['Ultra', 170, '8GB DDR4 RAM / 225% CPU / 50GB NVMe SSD'],
                    ['Pro', 250, '12GB DDR4 RAM / 275% CPU / 75GB NVMe SSD'],
                    ['Enterprise', 350, '16GB DDR4 RAM / 350% CPU / 100GB NVMe SSD'],
                    ['Titan', 650, '32GB DDR4 RAM / 400% CPU / 200GB NVMe SSD'],
                    ['GOD', 950, '48GB DDR4 RAM / 450% CPU / 250GB NVMe SSD'],
                ],
            ],
            [
                'slug' => 'premium-game-hosting',
                'name' => 'Premium Game Hosting',
                'description' => 'India AMD EPYC game server hosting.',
                'plans' => [
                    ['Starter', 100, '2GB DDR4 ECC RAM / 75% CPU Priority / 10GB NVMe SSD'],
                    ['Basic', 150, '3GB DDR4 ECC RAM / 100% CPU Priority / 18GB NVMe SSD'],
                    ['Performance', 200, '4GB DDR4 ECC RAM / 125% CPU Priority / 25GB NVMe SSD'],
                    ['Standard', 250, '5GB DDR4 ECC RAM / 150% CPU Priority / 30GB NVMe SSD'],
                    ['Ultra Boost', 300, '6GB DDR4 ECC RAM / 175% CPU Priority / 36GB NVMe SSD'],
                    ['Pro', 350, '7GB DDR4 ECC RAM / 200% CPU Priority / 42GB NVMe SSD'],
                    ['Pro Max', 400, '8GB DDR4 ECC RAM / 225% CPU Priority / 48GB NVMe SSD'],
                    ['Elite', 500, '10GB DDR4 ECC RAM / 275% CPU Priority / 60GB NVMe SSD'],
                    ['Enterprise', 600, '12GB DDR4 ECC RAM / 325% CPU Priority / 72GB NVMe SSD'],
                    ['Ultimate', 700, '14GB DDR4 ECC RAM / 350% CPU Priority / 84GB NVMe SSD'],
                    ['Titan', 800, '16GB DDR4 ECC RAM / 375% CPU Priority / 96GB NVMe SSD'],
                    ['Obsidian', 900, '18GB DDR4 ECC RAM / 425% CPU Priority / 108GB NVMe SSD'],
                    ['VIP', 1000, '20GB DDR4 ECC RAM / 475% CPU Priority / 120GB NVMe SSD'],
                    ['GOD', 1500, '32GB DDR4 ECC RAM / 500% CPU Priority / 160GB NVMe SSD'],
                ],
            ],
            [
                'slug' => 'discord-bot-hosting',
                'name' => 'Discord Bot Hosting',
                'description' => 'Bot hosting for Discord bots and lightweight services.',
                'plans' => [
                    ['BOT 1', 80, '0.5 CPU Core / 1GB DDR4 RAM / 5GB NVMe SSD'],
                    ['BOT 2', 120, '1 CPU Core / 3GB DDR4 RAM / 10GB NVMe SSD'],
                    ['BOT 3', 250, '1.5 CPU Cores / 4GB DDR4 RAM / 20GB NVMe SSD'],
                ],
            ],
        ];

        foreach ($categories as $categoryIndex => $categoryData) {
            $category = Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'full_slug' => $categoryData['slug'],
                    'sort' => $categoryIndex + 1,
                ],
            );

            foreach ($categoryData['plans'] as $planIndex => [$name, $amount, $description]) {
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($categoryData['slug'] . '-' . $name)],
                    [
                        'category_id' => $category->id,
                        'name' => $name,
                        'description' => $description,
                        'stock' => null,
                        'sort' => $planIndex + 1,
                        'allow_quantity' => 'disabled',
                    ],
                );

                $plan = $product->plans()->updateOrCreate(
                    ['name' => 'Monthly'],
                    [
                        'type' => 'recurring',
                        'billing_period' => 1,
                        'billing_unit' => 'month',
                        'sort' => 1,
                    ],
                );

                Price::updateOrCreate(
                    ['plan_id' => $plan->id, 'currency_code' => 'INR'],
                    ['price' => $amount, 'setup_fee' => 0],
                );
            }
        }
    }
}
