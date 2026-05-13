<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin123'),
        'user_type' => 'admin',
    ]);
        User::create([
            'name' => 'Normal User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'user_type' => 'user',
        ]);
        
    }
}
