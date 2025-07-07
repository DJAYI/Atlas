<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'email' => 'programador7@tecnocomfenalco.edu.co',
            'username' => 'Admin User',
            'password' => bcrypt('password'), // Ensure password is hashed
        ]);
        $admin->assignRole('admin');
        
        // Create auxiliary user
        $auxiliary = User::factory()->create([
            'email' => 'danilo.arenasyi@gmail.com',
            'username' => 'Auxiliar User',
            'password' => bcrypt('password'), // Ensure password is hashed
        ]);
        $auxiliary->assignRole('auxiliar');
        
    }
}
