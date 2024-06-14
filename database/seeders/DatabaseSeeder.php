<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Derlis',
            'username'=>env('USER_SEED','user'),
            'email' => env('EMAIL_SEED','demo@demo.com'),
            'password'=>env('PASSWORD_SEED',123456)
        ]);
    }
}
