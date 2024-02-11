<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
            'title' => 'Massage 1',
            'price' => 10000
            ],
            [
                'title' => 'Massage 2',
                'price' => 11000
            ],
            [
                'title' => 'Massage 3',
                'price' => 12000
            ],
        ];

        foreach ($services as $course) {
            Service::create($course);
        }
    }
}
