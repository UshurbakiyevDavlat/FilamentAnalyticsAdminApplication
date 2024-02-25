<?php

namespace App\Exceptions;

use App\Enums\StatusCodeEnum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthModelShouldBeEloquentException extends Exception
{
    /**
     * Log or report the exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error(__('exceptions.model.eloquent'));
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(
            [
                'error' => __('exceptions.model.eloquent'),
                'message' => $this->getMessage(),
            ],
            StatusCodeEnum::INTERNAL_SERVER_ERROR->value,
        );
    }
}
