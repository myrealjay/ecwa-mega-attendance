<?php


namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

trait HasResponse
{
    public function failedResponse($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.failed'),
            'message' => $message
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('black_bank.status.failed'));
    }

    public function successResponse($message, $data): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.success'),
            'message' => $message
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response);
    }

    public function serverErrorResponse($message, Exception $exception = null): JsonResponse
    {
        if ($exception !== null) {
            Log::error(
                "{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}"
            );
        }

        $response = [
            'status' => config('black_bank.status.failed'),
            'statuscode' => config('black_bank.status.server_error'),
            'message' => $message,
        ];

        if (config('app.debug')) {
            $response['debug'] = $this->appendDebugData($exception);
        }

        return Response::json($response, 500);
    }

    /**
     * Append debug data to the response data returned.
     */
    protected function appendDebugData($exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => collect($exception->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ];
    }

    public function notFoundResponse($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.not_found'),
            'message' => $message
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('black_bank.status.not_found'));
    }

    public function notAllowedResponse($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.not_allowed'),
            'message' => $message
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('black_bank.status.not_allowed'));
    }

    public function notAuthenticated($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.unauthenticated'),
            'message' => $message
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('black_bank.status.unauthenticated'));
    }

    public function formValidationResponse($errors, array $data = []): JsonResponse
    {
        $response = [
            'status' => config('black_bank.status.failed_validation'),
            'message' => 'Validation failed',
            'validationErrors' => $errors,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('black_bank.status.failed_validation'));
    }
}
