<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'transaksi_id' => 1,
                'user_id' => 2,
                'tanggal_transaksi' => now()->subDays(1),
                'total_harga' => 3*20000 + 2*15000, // 3x Cabai Merah + 2x Tomat Hijau
                'status' => 'Lunas',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'transaksi_id' => 2,
                'user_id' => 3,
                'tanggal_transaksi' => now()->subDays(1),
                'total_harga' => 1*25000, // 1x Bawang Merah
                'status' => 'Pending',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'transaksi_id' => 3,
                'user_id' => 7,
                'tanggal_transaksi' => now()->subDays(1),
                'total_harga' => 5*10000, // 5x Sayur Bayam
                'status' => 'Batal',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
        ];

        foreach ($datas as $data) {
            Transaksi::create($data);
        }
    }
}
