<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'from' => '08:00:00',
                'to'   => '09:00:00'
            ],
            [
                'from' => '09:00:00',
                'to'   => '10:00:00'
            ],
            [
                'from' => '10:00:00',
                'to'   => '11:00:00'
            ],
            [
                'from' => '12:00:00',
                'to'   => '13:00:00'
            ],
            [
                'from' => '13:00:00',
                'to'   => '14:00:00'
            ],
            [
                'from' => '14:00:00',
                'to'   => '15:00:00'
            ],
            [
                'from' => '15:00:00',
                'to'   => '16:00:00'
            ],
            [
                'from' => '16:00:00',
                'to'   => '17:00:00'
            ],
        ];

        foreach($schedules as $schedule) {
            Schedule::firstOrCreate($schedule);
        }
    }
}
