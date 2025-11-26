<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'امیرارسلان ابراهیمی',
                'mobile' => '09129727002',
                'email' => 'arsalan@bfit.ir',
                'email_verified_at' => now(),
                'password' => bcrypt('3711@Ars'),
                'is_superadmin' => true,
            ],
            [
                'name' => 'امیرحسین منظوری',
                'mobile' => '09121089007',
                'email' => 'manzouri@bfit.ir',
                'email_verified_at' => now(),
                'password' => bcrypt('Ho455645'),
            ],
            [
                'name' => 'امیرحسین حقی',
                'mobile' => '09127052397',
                'email' => 'haghi@bfit.ir',
                'email_verified_at' => now(),
                'password' => bcrypt('@Amir1371'),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
