<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
/**
 * @OA\Post(
 *     path="/auth/login",
 *     summary="Provides a JWT token by email and password credentials",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf = {
 *                 @OA\Schema(ref="#/components/schemas/LoginRequest")
 *             }
 *         )
 *     ),
 *     @OA\Response(response=200,description="Logged in")
 *     )
 * )
 * @param LoginRequest $request
 * @return JsonResponse
 *
 */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
