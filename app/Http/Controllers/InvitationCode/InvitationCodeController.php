<?php

namespace App\Http\Controllers\InvitationCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationCode\InvitationCodeRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\UseCases\InvitationCodes\CreateNewCodeUseCase;
use App\UseCases\InvitationCodes\FetchAllCodeListUseCase;
use Exception;
use Illuminate\Http\JsonResponse;

class InvitationCodeController extends Controller
{
    public function __construct(
        private FetchAllCodeListUseCase $fetchCodeListUseCase,
        private CreateNewCodeUseCase $createNewCodeUseCase
    ) {}

    // ページネーションさせるか
    public function fetchAllCodes(): JsonResponse
    {
        try {
            $codeInfoList = ($this->fetchCodeListUseCase)();
        } catch (Exception $e) {
            return ApiErrorResponse::make(
                title: 'invalid error',
                detail: $e->getMessage()
            )->toResponse();
        }

        $result = [];
        foreach ($codeInfoList as $code) {
            $result[] = [
                'id'          => $code->id,
                'code'        => $code->code,
                'role_id'     => $code->role_id,
                'expired_at'  => $code->expired_at,
                'created_at'  => $code->created_at,
                'redeemed_at' => $code->redeemed_at,
            ];
        }

        return ApiSuccessResponse::make(
            data: $result,
            title: "success"
        )->toResponse();
    }

    public function createNewCode(InvitationCodeRequest $request): JsonResponse
    {
        $request->validated();

        try {
            $newCode = ($this->createNewCodeUseCase)();
        } catch (Exception $e) {
            return ApiErrorResponse::make(
                title: 'invalid error',
                detail: $e->getMessage()
            )->toResponse();
        }

        return ApiSuccessResponse::make(
            data: [
                [
                    'id'          => $newCode->id,
                    'code'        => $newCode->code,
                    'role_id'     => $newCode->role_id,
                    'expired_at'  => $newCode->expired_at,
                    'created_at'  => $newCode->created_at,
                    'redeemed_at' => $newCode->redeemed_at,
                ]
            ],
            status: 201,
            title: "created"
        )->toResponse();
    }
}
