<?php

namespace App\Http\Services;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class ScheduleService
{
    public function list(string $userRole): Collection
    {
        return Schedule::availableForUser($userRole)->whereNull('user_id')->get();
    }

    public function bookSchedule(array $bookingData)
    {
        $userId = auth()->id();
        $serviceId = $bookingData['service_id'];
        $from = $bookingData['from'];

        $schedule = Schedule::where('from', $from)->whereNull('user_id')->first();

        if(!empty($schedule)) {
            abort(Response::HTTP_BAD_REQUEST, 'This time slot is already booked');
        }

        $schedule->update(['user_id' => $userId,'service_id' => $serviceId]);
        $schedule->refresh();

        return $schedule;
    }

    public function cancelSchedule(Schedule $schedule)
    {
        $userId = auth()->id();

        if ($schedule->user_id !== $userId) {
            abort(400, 'Appointment does not belong to you');
        }

        if (is_null($schedule->user_id)) {
            abort(400, 'This time slot is not booked and cannot be cancelled');
        }

        $schedule->update(['user_id' => null]);
    }

    public function reschedule($bookingData, $schedule)
    {
        $userId = auth()->id();
        $newFrom = $bookingData['new_from'];

        if ($schedule->user_id !== $userId) {
            return response()->json(['message' => 'Appointment not found or does not belong to you.'], 404);
        }

        $newSchedule = Schedule::where('from', $newFrom)
        ->whereNull('user_id')
        ->first();

        if (!$newSchedule) {
            return response()->json(['message' => 'The new time slot is already booked or does not exist.'], 400);
        }

        $schedule->update(['user_id' => null]);
        $newSchedule->update(['user_id' => $userId]);
    }
}

