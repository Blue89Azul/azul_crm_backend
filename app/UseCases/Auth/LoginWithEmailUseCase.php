<?php

namespace App\UseCases\Auth;

use App\Repositories\Tenant\TenantRepository;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginWithEmailUseCase
{
    public function __construct(
        protected TenantRepository $tenantRepository
    ) {}

    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $account     = $request->account;

        if (!$this->tenantRepository->hasSameAccount($account)) {
            throw new InvalidArgumentException("アカウントが存在しません");
        }

        tenancy()->initialize($account);

        try {
            $result = JWTAuth::attempt($credentials);
            tenancy()->end();
        } catch (Exception $e) {
            tenancy()->end();
            throw new InvalidArgumentException($e->getMessage());
        }

        return $result;
    }
}
