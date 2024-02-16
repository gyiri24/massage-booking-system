<?php

namespace App\Http\Controllers;


use App\Http\Resources\ScheduleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Http\Services\ScheduleService;
use App\Http\Requests\BookScheduleRequest;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }
    /**
     * @OA\Get(
     *     path="/schedules",
     *     summary="Get available schedules for user",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\Response(response=200,description="Return filtered schedule list"),
     *     @OA\Response(response=401,description="Unatuhorized"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index() : JsonResponse
    {
        $userRole = auth()->user()->roleName;

        return $this->ok(ScheduleResource::collection($this->scheduleService->list($userRole)));
    }
    /**
     * @OA\Post(
     *     path="/schedules",
     *     summary="Get schedules list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\Response(response=200,description="Return filtered rating list"),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function book(BookScheduleRequest $request)
    {
        $data = $request->only('service_id', 'from');

        return $this->ok($this->scheduleService->bookSchedule($data));
    }

    public function cancel(Schedule $schedule)
    {
        $this->scheduleService->cancelSchedule($schedule);

        return $this->noContent();
    }

    public function reschedule(Request $request, Schedule $schedule)
    {
        $data = $request->only('new_from', 'from');

        return $this->ok($this->scheduleService->reschedule($data, $schedule));
    }
}
