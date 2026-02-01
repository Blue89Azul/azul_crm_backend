<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * @template TData of array
 */
final class ApiSuccessResponse implements ApiResponse
{
    /**
     * @param TData $data
     */
    public function __construct(
        private array $data   = [],
        private string $title = '',
        private int $status   = 200,
        private array $meta   = []
    ) {}

    /**
     * @param TData $data
     * @return self<TData>
     */
    public static function make(
        array $data   = [],
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
            'data'  => $this->data,
            'meta'  => $this->meta,
        ], $this->status);
    }
}
