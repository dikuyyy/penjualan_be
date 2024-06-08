<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseResponse implements Responsable
{
    protected int $status;
    protected $data;
    protected string $errors;
    protected string $message;
    protected array $customAttributes;
    protected string $success;
    protected $useTotal;

    public function __construct($data = [], $message = '', $status = 200,$useTotal = false, $errors = '', $customAttributes = [], $success = true)
    {
        $this->status = $status;
        $this->data = $data;
        $this->errors = $errors;
        $this->message = $message;
        $this->customAttributes = $customAttributes;
        $this->success = $success;
        $this->useTotal = $useTotal;
    }

    public function addCustomAttributes($key, $value)
    {
        if (
            array_key_exists($key, $this->customAttributes)
            && is_array($this->customAttributes[$key])
            && is_array($value)
        ) {
            $this->customAttributes[$key] = array_merge($this->customAttributes[$key], $value);
        } else {
            $this->customAttributes[$key] = $value;
        }
    }

    public function toResponse($request): JsonResponse|Response
    {
        $payload = [
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message,
            'code' => $this->status
        ];

        if($this->useTotal) {
            $payload['total'] = count($payload['data']);
        }

        if (!empty($this->errors)) {
            $payload['errors'] = $this->errors;
        }

        if (!empty($this->customAttributes)) {
            $payload = array_merge($payload, $this->customAttributes);
        }

        return response()->json($payload, $this->status);
    }
}
