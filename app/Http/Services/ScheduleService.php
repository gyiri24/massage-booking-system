<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ScheduleService
{
    public const GENERAL_USER_DEADLINE = '11:00:00';
    public function list(string $userRole): Collection
    {
        return Schedule::availableForUser($userRole)->whereNull('user_id')->get();
    }

    public function bookSchedule(array $bookingData)
    {
        $user = auth()->user();
        $userId = $user->id;
        $serviceId = $bookingData['serviceId'];
        $from = $bookingData['from'];

        if (!$this->isUserEligibleForTimeSlot($user, $from)) {
            abort(Response::HTTP_FORBIDDEN, 'You are not eligible to book this time slot.');
        }

        $schedule = $this->getAvailableSchedule($from);

        if(empty($schedule)) {
            abort(Response::HTTP_BAD_REQUEST, 'This time slot is already booked');
        }

        $this->updateSchedule($schedule, $userId, $serviceId);

        return $schedule;
    }

    /**
     * @param User $user
     * @param string $from
     * @return bool
     */
    public function isUserEligibleForTimeSlot(User $user, string $from): bool
    {
        $userRole = $user->roleName;
        $isAvailableForUser = true;

        if ($userRole == Role::GENERAL_ROLE) {
            $isAvailableForUser = Carbon::createFromFormat('H:i:s', $from)
                ->lessThanOrEqualTo(Carbon::createFromFormat('H:i:s', self::GENERAL_USER_DEADLINE));
        }

        return $isAvailableForUser;
    }

    /**
     * @param string $from
     * @return mixed
     */
    public function getAvailableSchedule(string $from): mixed
    {
        $from = Carbon::createFromFormat('H:i:s', $from);

        return Schedule::where('from', $from)->whereNull('user_id')->first();
    }

    /**
     * @param Schedule $schedule
     * @param int $userId
     * @param int $serviceId
     * @return void
     */
    public function updateSchedule(Schedule $schedule, int $userId, int $serviceId): void
    {
        $schedule->update(['user_id' => $userId,'service_id' => $serviceId]);
        $schedule->refresh();
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

