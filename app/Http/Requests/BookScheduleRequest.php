<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *       schema="BookScheduleRequest",
 *       title="BookScheduleRequest",
 *       description="Schedule data",
 *       type="object",
 *       @OA\Property(
 *           property="serviceId",
 *           type="integer",
 *           example="1"
 *      ),
 *      @OA\Property(
 *           property="from",
 *           type="string",
 *           example="08:00:00"
 *      )
 *  )
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
            'serviceId' => 'required|integer|exists:services,id',
            'from' => 'required|exists:schedules,from',
        ];
    }
}
