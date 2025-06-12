<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'cart_id' => 2,
                'user_id' => 2,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'cart_id' => 3,
                'user_id' => 3,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'cart_id' => 7,
                'user_id' => 7,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
        ];

        foreach ($datas as $data) {
            Keranjang::create($data);
        }
    }
}
