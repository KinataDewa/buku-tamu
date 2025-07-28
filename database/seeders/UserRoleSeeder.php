<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Resepsionis Ground',
            'email' => 'ground@example.com',
            'password' => Hash::make('password123'),
            'role' => 'resepsionis_ground',
        ]);

        User::create([
            'name' => 'Resepsionis Lantai 5',
            'email' => 'lantai5@example.com',
            'password' => Hash::make('password123'),
            'role' => 'resepsionis_lantai5',
        ]);
    }
}
