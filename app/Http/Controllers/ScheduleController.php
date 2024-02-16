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
    private ScheduleService $scheduleService;

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
     *     @OA\Response(
     *           response=200,
     *           description="schedule list",
     *           @OA\JsonContent(
     *               type="array",
     *               @OA\Items(ref="#/components/schemas/ScheduleResource")
     *           ),
     *     ),
     *     @OA\Response(response=401, description="Protected endpoint only logged in users."),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index() : JsonResponse
    {
        $userRole = auth()->user()->role;

        return $this->ok(ScheduleResource::collection($this->scheduleService->list($userRole)));
    }
    /**
     * @OA\Post(
     *     path="/schedules",
     *     summary="Get schedules list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              allOf = {
     *                  @OA\Schema(ref="#/components/schemas/BookScheduleRequest")
     *             }
     *         )
     *     ),
     *     @OA\Response(response=200,description="Return booked schedule"),
     *     @OA\Response(response=401, description="Protected endpoint only logged in users."),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function book(BookScheduleRequest $request): JsonResponse
    {
        $data = $request->only('serviceId', 'from');

        return $this->ok(ScheduleResource::make($this->scheduleService->bookSchedule($data)));
    }
    /**
     * @OA\Put(
     *     path="/schedules/cancel",
     *     summary="Get schedules list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              allOf = {
     *                  @OA\Schema(ref="#/components/schemas/BookScheduleRequest")
     *             }
     *         )
     *     ),
     *     @OA\Response(response=200,description="Return booked schedule"),
     *     @OA\Response(response=401, description="Protected endpoint only logged in users."),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function cancel(Schedule $schedule): JsonResponse
    {
        $this->scheduleService->cancelSchedule($schedule);

        return $this->noContent();
    }
    /**
     * @OA\Put(
     *     path="/schedules/reschedule",
     *     summary="Get schedules list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              allOf = {
     *                  @OA\Schema(ref="#/components/schemas/BookScheduleRequest")
     *             }
     *         )
     *     ),
     *     @OA\Response(response=200,description="Return booked schedule"),
     *     @OA\Response(response=401, description="Protected endpoint only logged in users."),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function reschedule(Request $request, Schedule $schedule)
    {
        $data = $request->only('new_from', 'from');

        return $this->ok($this->scheduleService->reschedule($data, $schedule));
    }
}
