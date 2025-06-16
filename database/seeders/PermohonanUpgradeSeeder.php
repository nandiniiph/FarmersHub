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
                'user_id' => 3,
                'tanggal_permohonan' => now()->subDays(2),
                'nama_lengkap' => 'Harman Maulana',
                'nomor_hp' => '08234567890',
                'nama_usaha' => 'Usaha B',
                'alamat_lengkap' => 'Jl. Contoh No. 2, Bandung',
                'status' => 'Menunggu',
                'catatan_admin' => '',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 4,
                'tanggal_permohonan' => now()->subDays(2),
                'nama_lengkap' => 'Soni Santosa',
                'nomor_hp' => '082235045858',
                'nama_usaha' => 'Organik Nusantara',
                'alamat_lengkap' => 'Jl. Mawar No. 2, Bandung',
                'status' => 'Disetujui',
                'catatan_admin' => '',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 5,
                'tanggal_permohonan' => now()->subDays(2),
                'nama_lengkap' => 'Mita Faradina',
                'nomor_hp' => '085627189899',
                'nama_usaha' => 'Mitani Food',
                'alamat_lengkap' => 'Jl. Anggrek No. 4, Surabaya',
                'status' => 'Disetujui',
                'catatan_admin' => '',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 6,
                'tanggal_permohonan' => now()->subDays(2),
                'nama_lengkap' => 'Sanusi',
                'nomor_hp' => '082210103018',
                'nama_usaha' => 'Sanusi Farm Product',
                'alamat_lengkap' => 'Jl. Melati No. 6, Malang',
                'status' => 'Disetujui',
                'catatan_admin' => '',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 7,
                'tanggal_permohonan' => now()->subDays(3),
                'nama_lengkap' => 'Gita Delinda',
                'nomor_hp' => '08345678901',
                'nama_usaha' => 'Usaha C',
                'alamat_lengkap' => 'Jl. Contoh No. 3, Surabaya',
                'status' => 'Menunggu',
                'catatan_admin' => '',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ];

        foreach ($datas as $data) {
            PermohonanUpgrade::create($data);
        }
    }
}
