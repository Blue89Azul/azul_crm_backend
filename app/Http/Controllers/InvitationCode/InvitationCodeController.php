<?php

namespace App\Http\Controllers\InvitationCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationCode\InvitationCodeRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\InvitationCode;
use Illuminate\Http\JsonResponse;

class InvitationCodeController extends Controller
{
    // ページネーションさせるか
    public function fetchAllCodes(): JsonResponse
    {
        // 組織IDに紐づく招待コードを取得する

        return ApiSuccessResponse::make()->toResponse();
    }

    public function createNewCode(InvitationCodeRequest $request): JsonResponse
    {
        // 組織ID
        // ユーザーID
        // 

        InvitationCode::create([]);

        return ApiSuccessResponse::make()->toResponse();
    }
}
