<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/schedules",
     *     summary="Get schedules list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Schedules"},
     *     @OA\Response(response=200,description="Return filtered rating list"),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index() : JsonResponse {
        return $this->ok(ScheduleResource::collection(Schedule::available()->get()));
    }

    public function create(Request $request)
    {
        $userId = auth()->user()->id;
        $data = $request->only('userId', 'serviceId');

        return $userId;
    }
}
