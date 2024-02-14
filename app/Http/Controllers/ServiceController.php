<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/services",
     *     summary="Get rating list with filters",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Services"},
     *     @OA\Response(response=200,description="Return filtered rating list"),
     *     @OA\Response(response=422, description="Unprocessable entity!"),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index(): JsonResponse
    {
        return $this->ok(ServiceResource::collection(Service::all()));
    }
}
