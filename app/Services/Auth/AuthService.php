<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected AuthRepository $repository
    ) {}

    public function signup(
        string $email,
        string $password,
        ?string $invitation_code
    ): User {
        return $this->repository->createUser([
            'email'           => $email,
            'password'        => Hash::make($password),
            'invitation_code' => $invitation_code
        ]);
    }
}
