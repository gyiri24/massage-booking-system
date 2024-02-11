<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index() : JsonResponse {
        return response()->json(Schedule::available()->get(), 200);
    }
}
