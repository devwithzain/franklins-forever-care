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
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@franklins.com'],
            [
                'name' => 'Tassy Omah',
                'email' => 'admin@franklins.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Employee user
        User::updateOrCreate(
            ['email' => 'employee@franklins.com'],
            [
                'name' => 'Jane Smith',
                'email' => 'employee@franklins.com',
                'password' => bcrypt('password'),
                'role' => 'employee',
            ]
        );

        // Client user
        User::updateOrCreate(
            ['email' => 'client@franklins.com'],
            [
                'name' => 'Arthur Morgan',
                'email' => 'client@franklins.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );
    }
}
