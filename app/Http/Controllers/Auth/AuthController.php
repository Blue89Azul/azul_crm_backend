<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * signUp
     * @param \App\Http\Requests\Auth\SignUpRequest $request
     * @return JsonResponse
     * 
     * HTTPステータスをEnumで管理してもいいかも
     */
    public function signup(SignUpRequest $request): JsonResponse
    {
        $validated_data = $request->validated();

        // ユーザー追加
        $user = $this->authService->signup(
            $validated_data['email'],
            $validated_data['password'],
            $validated_data['invitation_code'] ?? ""
        );

        // JWTトークンの作成
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return ApiErrorResponse::make(
                'トークン作成の失敗',
                $e->getMessage(),
                500,
            )->toResponse();
        }

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ], 200);
    }
}
