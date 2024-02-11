<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'email' => 'david.gyori-dani@attrecto.com',
            'name' => 'Győri-Dani Dávid',
            'password' => Hash::make('Teszt123')
        ]);
    }
}
