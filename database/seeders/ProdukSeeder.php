<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'user_id' => 4,
                'nama_produk' => 'Cabai Merah',
                'deskripsi' => 'Cabai merah segar hasil panen lokal',
                'harga' => 20000,
                'stok' => 100,
                'gambar' => 'https://example.com/images/cabai-merah.jpg',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'user_id' => 5,
                'nama_produk' => 'Tomat Hijau',
                'deskripsi' => 'Tomat hijau segar, cocok untuk lalapan',
                'harga' => 15000,
                'stok' => 80,
                'gambar' => 'https://example.com/images/tomat-hijau.jpg',
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],
            [
                'user_id' => 6,
                'nama_produk' => 'Bawang Merah',
                'deskripsi' => 'Bawang merah berkualitas premium',
                'harga' => 25000,
                'stok' => 60,
                'gambar' => 'https://example.com/images/bawang-merah.jpg',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'user_id' => 9,
                'nama_produk' => 'Sayur Bayam',
                'deskripsi' => 'Sayur bayam hijau segar',
                'harga' => 10000,
                'stok' => 90,
                'gambar' => 'https://example.com/images/sayur-bayam.jpg',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
        ];

        foreach ($datas as $data) {
            Produk::create($data);
        }
    }
}
