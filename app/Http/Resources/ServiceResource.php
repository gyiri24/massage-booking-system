<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 *      title="ServiceResource",
 *      description="Contains service data",
 *      type="object",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          example="Massage 1",
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="string",
 *          example=10000,
 *      )
 * )
 */
class ServiceResource extends JsonResource
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
            'title' => $this->title,
            'price' => $this->currentPrice
        ];
    }
}
