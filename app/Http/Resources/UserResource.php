<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *      title="UserResource",
 *      description="Contains user data",
 *      type="object",
 *      @OA\Property(
 *           property="id",
 *           type="integer",
 *           description="User's id",
 *           example="1"
 *      ),
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           description="User's full name",
 *           example="Sample Name"
 *      ),
 *      @OA\Property(
 *           property="email",
 *           type="string",
 *           format="email",
 *           description="User's email",
 *           example="email@email.net"
 *      )
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
