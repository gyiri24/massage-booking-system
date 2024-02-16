<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => Role::GENERAL_ROLE
            ],
            [
                'name' => Role::VIP_ROLE
            ]
        ];

        foreach($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
