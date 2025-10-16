<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
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
     */
    public function signup(SignUpRequest $request): JsonResponse
    {
        // バリデーション
        $validated_data = $request->validated();

        // ユーザー追加
        $user = $this->authService->signup(
            $validated_data['email'],
            $validated_data['password'],
            $validated_data['invitation_code']
        );

        // JWTトークンの作成
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'token' => "error",
            ]);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function loginWithEmail(): void {}

    public function logout(): void {}
}
