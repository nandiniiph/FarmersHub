<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'username' => 'admin',
                'email' => 'admin1@gmail.com',
                'password' => 'password123',
                'role' => 'Admin',
                'status' => true,
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'username' => 'andika',
                'email' => 'konsumen1@gmail.com',
                'password' => 'password123',
                'role' => 'Konsumen',
                'status' => true,
                'created_at' => now()->subDays(29),
                'updated_at' => now()->subDays(29),
            ],
            [
                'username' => 'harman',
                'email' => 'konsumen2@gmail.com',
                'password' => 'password123',
                'role' => 'Konsumen',
                'status' => true,
                'created_at' => now()->subDays(28),
                'updated_at' => now()->subDays(28),
            ],
            [
                'username' => 'roni',
                'email' => 'petani1@gmail.com',
                'password' => 'password123',
                'role' => 'Petani',
                'status' => true,
                'created_at' => now()->subDays(27),
                'updated_at' => now()->subDays(27),
            ],
            [
                'username' => 'mita',
                'email' => 'petani2@gmail.com',
                'password' => 'password123',
                'role' => 'Petani',
                'status' => true,
                'created_at' => now()->subDays(26),
                'updated_at' => now()->subDays(26),
            ],
            [
                'username' => 'sanusi',
                'email' => 'petani3@gmail.com',
                'password' => 'password123',
                'role' => 'Petani',
                'status' => true,
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'username' => 'gita',
                'email' => 'konsumen3@gmail.com',
                'password' => 'password123',
                'role' => 'Konsumen',
                'status' => true,
                'created_at' => now()->subDays(24),
                'updated_at' => now()->subDays(24),
            ],
            [
                'username' => 'helmi',
                'email' => 'konsumen4@gmail.com',
                'password' => 'password123',
                'role' => 'Konsumen',
                'status' => false,
                'created_at' => now()->subDays(23),
                'updated_at' => now()->subDays(23),
            ],
            [
                'username' => 'andra',
                'email' => 'petani4@gmail.com',
                'password' => 'password123',
                'role' => 'Petani',
                'status' => false,
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22),
            ],
        ];

        foreach ($datas as $data) {
            Akun::create($data);
        }
    }
}
