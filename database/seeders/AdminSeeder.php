<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('Admin')->insert([
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'password_hash' => Hash::make('admin123'),
                'admin_type' => 'SuperAdmin',
                'created_at' => now(),
            ],
            [
                'first_name' => 'Regular',
                'last_name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('admin123'),
                'admin_type' => 'Admin',
                'created_at' => now(),
            ]
        ]);
    }
}