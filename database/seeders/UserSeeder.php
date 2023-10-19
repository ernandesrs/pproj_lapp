<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'username' => 'super123',
            'email' => 'super@mail.com',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin123',
            'email' => 'admin@mail.com',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser23',
            'email' => 'test@mail.com',
        ]);

        \App\Models\User::factory(20)->create();
    }
}
