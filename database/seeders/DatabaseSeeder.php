<?php

namespace Database\Seeders;

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
        Client::factory()->create([ 
            'firstname' => 'admin',
            'lastname' => 'admin',
            'password' => Hash::make('password'),
            'email' => 'admin@admin.com',
        ]);

        Client::factory(50)->create();
        Transaction::factory(50)->create();
    }
}
