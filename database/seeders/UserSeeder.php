<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Enums\ActiveStatus;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mr Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'active_status' => ActiveStatus::ACTIVE,
            'role' => Role::ADMIN,
        ]);

        User::create([
            'name' => 'Mr Employee',
            'email' => 'employee@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'active_status' => ActiveStatus::ACTIVE,
            'role' => Role::MANAGER,
        ]);

        Customer::create([
            'name' => 'Mr Customer 2',
            'email' => 'customer2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'active_status' => ActiveStatus::ACTIVE,
            'role' => Role::CUSTOMER,
        ]);

        Customer::create([
            'name' => 'Mr Customer',
            'email' => 'customer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'active_status' => ActiveStatus::ACTIVE,
            'role' => Role::CUSTOMER,
        ]);
    }
}