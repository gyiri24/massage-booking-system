<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 *
 * @OA\Schema(
 *      title="ScheduleResource",
 *      description="Contains schedule data",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="from",
 *          type="string",
 *          example="08:00:00",
 *      ),
 *      @OA\Property(
 *          property="to",
 *          type="string",
 *          example="09:00:00",
 *      ),
 *      @OA\Property(
 *          property="user",
 *          type="object",
 *          ref="#/components/schemas/UserResource"
 *       ),
 * )
 */
class ScheduleResource extends JsonResource
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
            'from' => $this->from,
            'to' => $this->to,
            'user' => UserResource::make($this->user)
        ];
    }
}
