<?php

namespace App\Livewire\Products;

use App\Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    public $product;

    public Category $category;

    public function mount($product)
    {
        $this->product = $this->category->products()->where('slug', $product)->where('hidden', false)->with(['plans.prices', 'configOptions.children.plans.prices'])->firstOrFail();
    }

    public function render()
    {
        return view('products.show')->layoutData([
            'title' => $this->product->name,
            'description' => strip_tags($this->product->description ?: 'Order the ' . $this->product->name . ' hosting plan from Vexora Cloud. Secure checkout, NVMe storage, DDoS-protected infrastructure and customer billing by Paymenter.'),
            'image' => $this->product->image ? Storage::url($this->product->image) : null,
        ]);
    }
}
