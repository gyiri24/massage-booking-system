<?php

namespace App\Http\Controllers;


use App\Http\Resources\ScheduleResource;
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
     *     @OA\Response(response=200,description="Return filtered schedule list"),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index() : JsonResponse {
        $userRole = auth()->user()->roleName;
        return $this->ok(ScheduleResource::collection(Schedule::availableForUser($userRole)->whereNull('user_id')->get()));
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
    public function create(Request $request)
    {
        $userId = auth()->id();
        $serviceId = $request->service_id;
        $from = $request->from;
        $to = $request->to;

        $isAvailable = !Schedule::where('service_id', $serviceId)->where(function ($query) use ($from, $to) {
            $query->whereBetween('from', [$from, $to])
                  ->orWhereBetween('to', [$from, $to]);
        })->exists();

        Schedule::create([
            'user_id' => $userId,
            'service_id' => $serviceId,
            'from' => $from,
            'to' => $to,
        ]);

        return $userId;
    }
}
