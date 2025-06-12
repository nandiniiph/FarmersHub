<?php

namespace Database\Seeders;

use App\Models\DetailKeranjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailKeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detailKeranjangData = [
            [
                'cart_id' => 2, // andika
                'product_id' => 1, // Cabai Merah
                'jumlah' => 3,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'cart_id' => 2, // andika
                'product_id' => 2, // Tomat Hijau
                'jumlah' => 2,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'cart_id' => 3, // harman
                'product_id' => 3, // Bawang Merah
                'jumlah' => 1,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'cart_id' => 7, // gita
                'product_id' => 4, // Sayur Bayam
                'jumlah' => 5,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
        ];

        foreach ($detailKeranjangData as $detailCart) {
            DetailKeranjang::create($detailCart);
        }
    }
}
