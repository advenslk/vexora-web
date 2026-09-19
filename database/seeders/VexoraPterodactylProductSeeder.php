<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class VexoraPterodactylProductSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            'budget-game-hosting-nano' => [3, 1, 2048, 75, 15360],
            'budget-game-hosting-starter' => [3, 1, 4096, 125, 25600],
            'budget-game-hosting-performance' => [3, 1, 6144, 175, 35840],
            'budget-game-hosting-ultra' => [3, 1, 8192, 225, 51200],
            'budget-game-hosting-pro' => [3, 1, 12288, 275, 76800],
            'budget-game-hosting-enterprise' => [3, 1, 16384, 350, 102400],
            'budget-game-hosting-titan' => [3, 1, 32768, 400, 204800],
            'budget-game-hosting-god' => [3, 1, 49152, 450, 256000],
            'premium-game-hosting-starter' => [3, 1, 2048, 75, 10240],
            'premium-game-hosting-basic' => [3, 1, 3072, 100, 18432],
            'premium-game-hosting-performance' => [3, 1, 4096, 125, 25600],
            'premium-game-hosting-standard' => [3, 1, 5120, 150, 30720],
            'premium-game-hosting-ultra-boost' => [3, 1, 6144, 175, 36864],
            'premium-game-hosting-pro' => [3, 1, 7168, 200, 43008],
            'premium-game-hosting-pro-max' => [3, 1, 8192, 225, 49152],
            'premium-game-hosting-elite' => [3, 1, 10240, 275, 61440],
            'premium-game-hosting-enterprise' => [3, 1, 12288, 325, 73728],
            'premium-game-hosting-ultimate' => [3, 1, 14336, 350, 86016],
            'premium-game-hosting-titan' => [3, 1, 16384, 375, 98304],
            'premium-game-hosting-obsidian' => [3, 1, 18432, 425, 110592],
            'premium-game-hosting-vip' => [3, 1, 20480, 475, 122880],
            'premium-game-hosting-god' => [3, 1, 32768, 500, 163840],
            'discord-bot-hosting-bot-1' => [15, 1, 1024, 50, 5120],
            'discord-bot-hosting-bot-2' => [15, 1, 3072, 100, 10240],
            'discord-bot-hosting-bot-3' => [15, 1, 4096, 150, 20480],
        ];

        foreach ($plans as $slug => [$nestId, $eggId, $memory, $cpu, $disk]) {
            $product = Product::where('slug', $slug)->first();

            if (!$product) {
                continue;
            }

            foreach ($this->settings($nestId, $eggId, $memory, $cpu, $disk) as $key => [$value, $type]) {
                $product->settings()->updateOrCreate(
                    [
                        'key' => $key,
                        'settingable_type' => $product->getMorphClass(),
                    ],
                    [
                        'value' => $value,
                        'type' => $type,
                        'encrypted' => false,
                    ],
                );
            }
        }
    }

    private function settings(int $nestId, int $eggId, int $memory, int $cpu, int $disk): array
    {
        return [
            'location_ids' => [[], 'array'],
            'node' => ['', 'string'],
            'nest_id' => [(string) $nestId, 'string'],
            'egg_id' => [(string) $eggId, 'string'],
            'memory' => [$memory, 'integer'],
            'swap' => [0, 'integer'],
            'disk' => [$disk, 'integer'],
            'io' => [500, 'integer'],
            'cpu' => [$cpu, 'integer'],
            'cpu_pinning' => ['', 'string'],
            'databases' => [0, 'integer'],
            'backups' => [1, 'integer'],
            'additional_allocations' => [0, 'integer'],
            'port_array' => ['', 'string'],
            'port_range' => [[], 'array'],
            'skip_scripts' => [false, 'boolean'],
            'dedicated_ip' => [false, 'boolean'],
            'start_on_completion' => [true, 'boolean'],
            'oom_killer' => [false, 'boolean'],
        ];
    }
}
