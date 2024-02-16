<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

trait ExceptionResponseTrait
{
    /**
     * @OA\Schema(
     *      schema="errorResponse",
     *      title="errorResponse",
     *      type="object",
     *      @OA\Property(
     *          property="errors",
     *          type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="error message",
     *                      ),
     *                  )
     *      ),
     * ),
     */
    protected function errorResponse(
        string $message,
        int $statusCode = 500,
        array $exceptionTrace = [],
        ?string $scope = null,
        array $values = []
    ): JsonResponse {
        if (!is_null($scope)) {
            $errorArray['scope'] = $scope;
        }

        $errorArray['message'] = $message;

        if (!empty($values)) {
            $errorArray['values'] = $values;
        }

        if (!empty($exceptionTrace) && config('app.debug')) {
            $errorArray['trace'] = $exceptionTrace;
        }

        return response()
            ->json(['errors' => [$errorArray]], $statusCode)
            ->header('Content-Type', 'application/json');
    }
}