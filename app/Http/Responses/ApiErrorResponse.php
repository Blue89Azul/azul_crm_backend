<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class ApiErrorResponse implements ApiResponse
{
    const SWAGGER_URL = "https://api.example.com/docs/";

    public function __construct(
        private string $type,
        private string $title,
        private int $status,
        private string $detail,
        private string $instance,
        private string $timestamp,
    ) {}

    public static function make(
        string $title,
        string $detail,
        int $status = 400,
        ?string $type = null,
        ?string $instance = null
    ): self {
        return new self(
            $type ?? self::SWAGGER_URL,
            $title,
            $status,
            $detail,
            $instance ?? request()->path(),
            now()->toISOString()
        );
    }

    public function toResponse(): JsonResponse
    {
        return response()->json([
            'type'      => $this->type,
            'title'     => $this->title,
            'status'    => $this->status,
            'detail'    => $this->detail,
            'instance'  => $this->instance,
            'timestamp' => $this->timestamp,
        ], $this->status);
    }
}
