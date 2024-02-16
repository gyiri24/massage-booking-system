<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/services",
     *     summary="Get service list",
     *     security={ {"bearerAuth" : {}}},
     *     tags={"Services"},
     *     @OA\Response(
     *          response=200,
     *          description="service list",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ServiceResource")
     *          ),
     *     ),
     *     @OA\Response(response=401, description="Protected endpoint only logged in users."),
     *     @OA\Response(response=500, description="Internal server error!")
     * )
     */
    public function index(): JsonResponse
    {
        return $this->ok(ServiceResource::collection(Service::all()));
    }
}
