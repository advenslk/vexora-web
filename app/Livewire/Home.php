<?php

namespace App\Livewire;

use App\Models\Category;

class Home extends Component
{
    public function render()
    {
        return view('home', [
            // Categories which have NO parent and at least one child
            'categories' => Category::whereNull('parent_id')
                ->where(function ($query) {
                    $query->whereHas('children')
                        ->orWhereHas('products', function ($query) {
                            $query->where('hidden', false);
                        });
                })
                ->with(['products.plans.prices'])
                ->orderBy('sort')
                ->get(),
            'title' => 'Minecraft Server Hosting India, Discord Bot Hosting & Cloud Billing',
            'description' => 'Vexora Cloud, founded by Ayush Kumar Jha, offers Minecraft server hosting in India, Discord bot hosting, NVMe storage, DDoS-protected infrastructure and a secure Paymenter billing panel.',
        ]);
    }
}
