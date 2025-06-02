<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsers extends Command
{
    protected $signature = 'users:check';
    protected $description = 'Check users in the database';

    public function handle()
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->error('No users found in the database!');
            return;
        }

        $this->info('Users in the database:');
        foreach ($users as $user) {
            $this->line("ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}");
        }
    }
} 