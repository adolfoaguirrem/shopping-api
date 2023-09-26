<?php

namespace App\Infrastructure\Listener\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;

class APIResponse extends JsonResponse
{
    /**
     * ApiResponse constructor.
     *
     * @param string $message
     * @param mixed  $data
     * @param array  $errors
     * @param int    $status
     * @param array  $headers
     * @param bool   $json
     */
    public function __construct(string $message, $data = null, array $errors = [], int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct([
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ], $status, $headers, $json);
    }
}