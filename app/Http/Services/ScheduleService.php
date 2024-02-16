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

    /**
     * @param array $bookingData
     * @return mixed
     */
    public function bookSchedule(array $bookingData): mixed
    {
        $user = auth()->user();
        $userId = $user->id;
        $serviceId = $bookingData['serviceId'];
        $from = $bookingData['from'];

        if (!$this->isUserEligibleForTimeSlot($user, $from)) {
            abort(Response::HTTP_FORBIDDEN, 'You are not eligible to book this time slot.');
        }

        $schedule = $this->getAvailableSchedule($from);

        if (empty($schedule)) {
            abort(Response::HTTP_BAD_REQUEST, 'This time slot is already booked');
        }

        $this->updateSchedule($schedule, $userId, $serviceId);

        return $schedule;
    }


    /**
     * @param Schedule $schedule
     * @return void
     */
    public function cancelSchedule(Schedule $schedule): void
    {
        $userId = auth()->id();

        if (is_null($schedule->user_id)) {
            abort(Response::HTTP_BAD_REQUEST, 'This time slot is not booked and cannot be cancelled');
        }

        if ($schedule->user_id !== $userId) {
            abort(Response::HTTP_BAD_REQUEST, 'Appointment does not belong to you');
        }

        $this->updateSchedule($schedule, null, null);
    }

    /**
     * @param array $data
     * @param Schedule $schedule
     * @return mixed
     */
    public function reschedule(array $data, Schedule $schedule): mixed
    {
        $userId = auth()->id();
        $newFrom = $data['newFrom'];
        $serviceId = $data['serviceId'];

        if ($schedule->user_id !== $userId) {
            abort(Response::HTTP_BAD_REQUEST, 'Appointment does not belong to you');
        }

        $newSchedule = $this->getAvailableSchedule($newFrom);

        if (empty($newSchedule)) {
            abort(Response::HTTP_BAD_REQUEST, 'The new time slot is already booked');
        }

        $this->updateSchedule($schedule, null, null);
        $this->updateSchedule($newSchedule, $userId, $serviceId);

        return $newSchedule;
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
     * @param int|null $userId
     * @param int|null $serviceId
     * @return void
     */
    public function updateSchedule(Schedule $schedule, int|null $userId, int|null $serviceId): void
    {
        $schedule->update(['user_id' => $userId, 'service_id' => $serviceId]);
        $schedule->refresh();
    }
}

