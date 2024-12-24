<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'phone' => '(55) 5 5555-5555',
            'document' => '999.999.999-99',
            'password' => Hash::make('password'),
        ]);
    }
}
