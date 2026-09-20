<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@toko.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kasir 1',
                'email' => 'kasir@toko.com',
                'password' => bcrypt('password'),
                'role' => 'cashier',
            ],
            [
                'name' => 'Pemilik Toko',
                'email' => 'owner@toko.com',
                'password' => bcrypt('password'),
                'role' => 'owner',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
