<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminAndLawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'nusabudi48@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('123456789'),
                'role' => 'admin',
            ]
        );
        \App\Models\User::updateOrCreate(
            ['email' => 'lawyer@gmail.com'],
            [
                'name' => 'Lawyer User',
                'password' => bcrypt('123456789'),
                'role' => 'lawyer',
            ]
        );
    }
}
