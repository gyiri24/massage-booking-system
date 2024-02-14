<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *      title="LoginRequest",
 *      description="Register a non exisiting user",
 *      type="object",
 *      @OA\Property(
 *          property="email",
 *          description="User's email address",
 *          example="general.user@teszt.com"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="User's password",
 *          example="Teszt123"
 *      ),
 *      required={"email", "password"}
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|min:1',
            'password' => 'required|string',
        ];
    }
}
