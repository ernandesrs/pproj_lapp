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
        $roleSuper = \App\Models\Role::where('id', 1)->first();
        $roleAdmin = \App\Models\Role::where('id', 2)->first();

        \App\Models\User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'username' => 'super123',
            'email' => 'super@mail.com',
        ])->roles()->attach($roleSuper->id);

        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin123',
            'email' => 'admin@mail.com',
        ])->roles()->attach($roleAdmin->id);

        \App\Models\User::factory(100)->create();
    }
}
