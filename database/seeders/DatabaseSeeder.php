<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@rentalhalls.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Admin::create([
            'id' => $adminUser->id,
            'department' => 'System Administration',
            'phone' => null,
        ]);

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@rentalhalls.com');
        $this->command->info('Password: admin123');
    }
}
