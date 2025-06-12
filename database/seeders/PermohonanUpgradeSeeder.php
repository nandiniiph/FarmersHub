<?php

namespace Database\Seeders;

use App\Models\PermohonanUpgrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermohonanUpgradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'user_id' => 2,
                'tanggal_permohonan' => now()->subDays(1),
                'status' => 'Menunggu',
                'catatan_admin' => '',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'user_id' => 3,
                'tanggal_permohonan' => now()->subDays(2),
                'status' => 'Menunggu',
                'catatan_admin' => '',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 7,
                'tanggal_permohonan' => now()->subDays(3),
                'status' => 'Menunggu',
                'catatan_admin' => '',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'user_id' => 8,
                'tanggal_permohonan' => now()->subDays(4),
                'status' => 'Ditolak',
                'catatan_admin' => 'Status tidak aktif',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
        ];

        foreach ($datas as $data) {
            PermohonanUpgrade::create($data);
        }
    }
}
