<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@candycrafthub.com',
                'phone' => '+234 801 000 0001',
                'address' => '12 Candy Lane',
                'state' => 'Lagos',
                'country' => 'Nigeria',
            ],
            [
                'first_name' => 'Ops',
                'last_name' => 'Manager',
                'email' => 'ops@candycrafthub.com',
                'phone' => '+234 801 000 0002',
                'address' => '12 Candy Lane',
                'state' => 'Lagos',
                'country' => 'Nigeria',
            ],
        ];

        foreach ($admins as $admin) {
            User::query()->updateOrCreate(
                ['email' => $admin['email']],
                [
                    ...$admin,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'user_type' => UserType::Admin,
                ]
            );
        }
    }
}
