<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\RequestBody(
 *     request="BookScheduleRequest",
 *     required=true,
 *     description="Book a schedule slot",
 *     @OA\JsonContent(
 *         required={"serviceId", "from"},
 *         @OA\Property(property="serviceId", type="integer", example=1),
 *         @OA\Property(property="from", type="string", format="time", example="14:00")
 *     )
 * )
 */
class BookScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'serviceId' => 'required|integer|exists:schedules,service_id',
            'from' => 'required|exists:schedules,from',
        ];
    }
}
