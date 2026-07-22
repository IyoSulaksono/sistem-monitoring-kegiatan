<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'name' => 'Administrator Diskominfo',
            'email' => 'admin@medan.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'position' => 'Kepala Bidang Layanan E-Government',
            'phone' => '081234567890',
        ]);

        User::create([
            'username' => 'pptk',
            'name' => 'Rahmat Hidayat, S.Kom (PPTK)',
            'email' => 'pptk@medan.go.id',
            'password' => Hash::make('password'),
            'role' => 'pptk',
            'position' => 'Pejabat Pelaksana Teknis Kegiatan',
            'phone' => '081298765432',
        ]);

        User::create([
            'username' => 'staf',
            'name' => 'Budi Pratama, S.T.',
            'email' => 'staf@medan.go.id',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'position' => 'Pranata Komputer Ahli Pertama',
            'phone' => '085211223344',
        ]);

        User::create([
            'username' => 'siti',
            'name' => 'Siti Nurhaliza, A.Md.',
            'email' => 'siti@medan.go.id',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'position' => 'Pengelola Data Informatika',
            'phone' => '081377889900',
        ]);
    }
}
