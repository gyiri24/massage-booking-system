<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
/**
 * @OA\Server(
 *      url="/api",
 *      description="Local server"
 * )
 * @OA\Info(
 *      version="1.0.0",
 *      title="Massage Booking System API",
 *      description="Massage Booking System available endpoints list"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function ok(array|string|JsonResource $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Return with the created data.
     */
    protected function created(array|string|JsonResource $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

        /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
