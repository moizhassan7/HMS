<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@hms.com',
            'password' => Hash::make('password'),
            'branch' => 'Main',
        ]);

        // Create doctor user
        User::create([
            'name' => 'Dr. John Doe',
            'username' => 'doctor',
            'email' => 'doctor@hms.com',
            'password' => Hash::make('password'),
            'branch' => 'Main',
        ]);

        // Create receptionist user
        User::create([
            'name' => 'Jane Smith',
            'username' => 'receptionist',
            'email' => 'receptionist@hms.com',
            'password' => Hash::make('password'),
            'branch' => 'Main',
        ]);
    }
}
