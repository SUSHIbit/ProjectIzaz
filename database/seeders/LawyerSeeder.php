<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LawyerSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Lawyer',
            'email' => 'lawyer@gmail.com',
            'password' => '123456789',
            'role' => 'lawyer',
            'email_verified_at' => now(),
        ]);
    }
} 