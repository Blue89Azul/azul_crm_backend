<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\Auth\AuthService;
use App\UseCases\Auth\LoginWithEmailUseCase;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected LoginWithEmailUseCase $loginWithEmailUseCase
    ) {}

    /**
     * SignUp
     * 
     * @param \App\Http\Requests\Auth\SignUpRequest $request
     * @return JsonResponse
     */
    #[Response(
        status: 200,
        description: 'User registration successful',
        type: 'array{title: string, data: array{account: string, jwt: string, user: array{email: string, role_id: int}}, meta: array}'
    )]
    #[Response(
        status: 400,
        description: 'Validation error',
        type: 'array{type: string, title: string, status: int, detail: string, instance: string, timestamp: string}'
    )]
    #[Response(
        status: 500,
        description: 'Token creation failed',
        type: 'array{type: string, title: string, status: int, detail: string, instance: string, timestamp: string}'
    )]
    public function signup(SignUpRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userRole = UserRole::tryFrom($data['role']);

        if (is_null($userRole)) {
            return ApiErrorResponse::make(
                'Token creation failed',
                'User role is not included in the request',
                400,
            )->toResponse();
        }

        $result = null;
        if ($userRole->isAdmin()) {
            $result  = $this->authService->signupByAdmin(
                $data['account'],
                $data['email'],
                $data['password'],
            );
        }

        if ($userRole->isMember()) {
            $result  = $this->authService->signupByMember(
                $data['account'],
                $data['email'],
                $data['password'],
                $data['code']
            );
        }

        $user = $result['user'];

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return ApiErrorResponse::make(
                'Token creation failed',
                $e->getMessage(),
                500,
            )->toResponse();
        }

        return ApiSuccessResponse::make(
            data: [
                'account' => $request->account,
                'jwt'     => $token,
                'user'    => [
                    'email'   => $user->email,
                    'role_id' => $user->user_role_id,
                ]
            ],
        )->toResponse();
    }

    /**
     * Login with credentail data
     * 
     * @param Request $request
     * @return JsonResponse
     */
    #[Response(
        status: 200,
        description: 'Success',
        type: 'array{title: string, data: array{account: string, jwt: string, user: array{email: string, role_id: int}}, meta: array}'
    )]
    #[Response(
        status: 401,
        description: 'Authentication failed',
        type: 'array{type: string, title: string, status: int, detail: string, instance: string, timestamp: string}'
    )]
    #[Response(
        status: 500,
        description: 'Server Error',
        type: 'array{type: string, title: string, status: int, detail: string, instance: string, timestamp: string}'
    )]
    public function login(Request $request): JsonResponse
    {
        try {
            $token = ($this->loginWithEmailUseCase)($request);
            if (!$token) {
                return ApiErrorResponse::make(
                    title: 'Invalid credentials',
                    detail: 401,
                )->toResponse();
            }
        } catch (JWTException $e) {
            return ApiErrorResponse::make(
                title: 'Invalid credentials',
                detail: $e->getMessage(),
                status: 500,
            )->toResponse();
        }

        $user = Auth::user();

        return ApiSuccessResponse::make(
            data: [
                'account' => $request->account,
                'jwt'     => $token,
                'user'    => [
                    'email'   => $user->email,
                    'role_id' => $user->user_role_id,
                ]
            ],
        )->toResponse();
    }

    /**
     * Logout
     * 
     * @return JsonResponse
     */
    #[Response(
        status: 200,
        description: 'Success',
        type: 'array{title: string, data: array{message: log out successfully}, meta: array}'
    )]
    #[Response(
        status: 500,
        description: 'Server Error',
        type: 'array{type: string, title: string, status: int, detail: string, instance: string, timestamp: string}'
    )]
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return ApiErrorResponse::make(
                title: 'Invalid credentials',
                detail: $e->getMessage(),
                status: 500,
            )->toResponse();
        }

        return ApiSuccessResponse::make(
            data: [
                'message' => 'log out successfully'
            ]
        )->toResponse();
    }
}
