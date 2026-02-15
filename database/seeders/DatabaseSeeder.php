<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin (no company)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'company_id' => null,
        ]);

        // Create a sample company with admin and member
        $company = Company::create([
            'name' => 'Sample Company',
            'email' => 'company@example.com',
            'phone' => '1234567890',
        ]);

        // Company Admin
        User::create([
            'name' => 'Company Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_id' => $company->id,
        ]);

        // Company Member
        User::create([
            'name' => 'Company Member',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'company_id' => $company->id,
        ]);

        // Create another company with users
        $company2 = Company::create([
            'name' => 'Another Company',
            'email' => 'another@example.com',
            'phone' => '0987654321',
        ]);

        User::create([
            'name' => 'Another Admin',
            'email' => 'another.admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_id' => $company2->id,
        ]);

        User::create([
            'name' => 'Another Member',
            'email' => 'another.member@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'company_id' => $company2->id,
        ]);
    }
}