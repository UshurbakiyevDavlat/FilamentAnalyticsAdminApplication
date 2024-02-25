<?php

namespace App\Exceptions;

use App\Enums\StatusCodeEnum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JwtException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error('JWT Auth Exception: ' . $this->getMessage());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            [
                'error' => 'JWT Auth Exception',
                'message' => $this->getMessage(),
            ],
            StatusCodeEnum::INTERNAL_SERVER_ERROR->value
        );
    }
}
