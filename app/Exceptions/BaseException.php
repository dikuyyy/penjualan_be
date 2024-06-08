<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseException implements Responsable
{
    protected $message, $status, $success;

    public function __construct($message = '', $status = 400, $success = false)
    {
        $this->message = $message;
        $this->status = $status;
        $this->success = $success;
    }

    public function toResponse($request): JsonResponse|Response
    {
        $payload = [
            'success' => $this->success,
            'error' => [
                'code' => $this->status,
                'message' => $this->message
            ]
        ];

        return response()->json($payload, $this->status);
    }
}
