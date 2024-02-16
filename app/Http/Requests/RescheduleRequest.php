<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *       schema="RescheduleRequest",
 *       title="RescheduleRequest",
 *       description="Schedule data",
 *       type="object",
 *       @OA\Property(
 *           property="serviceId",
 *           type="integer",
 *           example="1"
 *       ),
 *       @OA\Property(
 *           property="newFrom",
 *           type="string",
 *           example="09:00:00"
 *      )
 *  )
 */
class RescheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'serviceId' => 'required|integer|exists:services,id',
            'newFrom' => 'required|string|exists:schedules,from'
        ];
    }
}
