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
            'name' => 'Satrio Sulaksono, S.T.',
            'email' => 'admin@medan.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'position' => 'Administrator',
            'phone' => '081274731269',
        ]);

        User::create([
            'username' => 'pptk',
            'name' => 'Juang Akbar Harahap, S.Kom',
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
