<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Gung Diah',
                'email' => 'agungparwati20@gmail.com',
                'password' => 'DiahAdmin#123',
            ],
            [
                'name' => 'Reva',
                'email' => 'putureva28@gmail.com',
                'password' => 'RevaAdmin#123',
            ],
            [
                'name' => 'Rere',
                'email' => 'revalinagirsang54@gmail.com',
                'password' => 'RereAdmin#123',
            ],
            [
                'name' => 'Febri',
                'email' => 'niputufebriantitrpl@gmail.com',
                'password' => 'FebriAdmin#123',
            ],
            [
                'name' => 'Natania',
                'email' => 'taniatasya252@gmail.com',
                'password' => 'NataniaAdmin#123',
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => $admin['password'],
                    'role' => 'admin',
                ]
            );
        }
    }
}