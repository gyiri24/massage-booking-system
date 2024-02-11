<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generalRoleId = Role::where('name', Role::GENERAL_ROLE)->first()->id;
        $vipRoleId = Role::where('name', Role::VIP_ROLE)->first()->id;

        $users = [
            [
                'email' => 'general.user@teszt.com',
                'name' => 'General User',
                'password' => Hash::make('Teszt123'),
                'role_id' => $generalRoleId
            ],
            [
                'email' => 'vip.user@teszt.com',
                'name' => 'Vip User',
                'password' => Hash::make('Teszt123'),
                'role_id' => $vipRoleId
            ],
        ];


        foreach ($users as $user) {
            User::firstOrCreate($user);
        }
    }
}
