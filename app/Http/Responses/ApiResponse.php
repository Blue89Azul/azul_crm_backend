<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

interface ApiResponse
{
    public function toResponse(): JsonResponse;
}
