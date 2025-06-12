<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'transaksi_id' => 1,
                'product_id' => 1,
                'jumlah' => 3,
                'harga_satuan' => 20000,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'transaksi_id' => 1,
                'product_id' => 2,
                'jumlah' => 2,
                'harga_satuan' => 15000,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'transaksi_id' => 2,
                'product_id' => 3,
                'jumlah' => 1,
                'harga_satuan' => 25000,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'transaksi_id' => 2,
                'product_id' => 4,
                'jumlah' => 5,
                'harga_satuan' => 10000,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
        ];

        foreach ($datas as $data) {
            DetailTransaksi::create($data);
        }
    }
}
