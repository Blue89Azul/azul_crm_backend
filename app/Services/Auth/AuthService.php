<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepository;

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
        $now = now();

        return $this->repository->createUser([
            'email'           => $email,
            'password'        => $password,
            'invitation_code' => $invitation_code,
            'created_at'      => $now,
            'updated_at'      => $now,
            'loggedin_at'     => $now,
        ]);
    }
}
