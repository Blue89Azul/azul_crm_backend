<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class ApiSuccessResponse implements ApiResponse
{
    public function __construct(
        private mixed $data   = null,
        private string $title = '',
        private int $status   = 200,
        private array $meta   = []
    ) {}

    public static function make(
        mixed $data   = null,
        string $title = 'success',
        int $status   = 200,
        array $meta   = []
    ): self {
        return new self(
            $data,
            $title,
            $status,
            $meta
        );
    }

    public function toResponse(): JsonResponse
    {
        return response()->json([
            'title' => $this->title,
            'data'  => $this->data ?? [],
            'meta'  => $this->meta,
        ], $this->status);
    }
}
