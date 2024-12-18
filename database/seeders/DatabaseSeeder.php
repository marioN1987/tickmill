<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([ 
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'email' => 'admin@admin.com',
        ]);

        Transaction::factory(50)->create();
    }
}
