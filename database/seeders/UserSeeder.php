<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ Import this

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@admin.com'),
                'role' => 'admin',
            ],
            [
                'name' => 'Shamsher',
                'email' => 'user@user.com',
                'password' => Hash::make('user@user.com'),
                'role' => 'employee',
            ],
        ];

        User::insert($users);

        User::factory()->count(5)->create([
            'role' => 'employee',
        ]);
    }
}
