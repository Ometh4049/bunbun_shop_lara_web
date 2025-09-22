<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create main admin user
        User::updateOrCreate(
            ['email' => 'admin@sweetdelights.lk'],
            [
                'name' => 'Sweet Delights Admin',
                'email' => 'admin@sweetdelights.lk',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create secondary admin user
        User::updateOrCreate(
            ['email' => 'manager@sweetdelights.lk'],
            [
                'name' => 'Bakery Manager',
                'email' => 'manager@sweetdelights.lk',
                'password' => Hash::make('manager123'),
                'role' => 'admin',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Update existing admin user to have is_admin flag
        User::where('email', 'admin@cafeelixir.lk')->update([
            'is_admin' => true
        ]);

        $this->command->info('Admin users created successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@sweetdelights.lk | Password: admin123');
        $this->command->info('Email: manager@sweetdelights.lk | Password: manager123');
    }
}