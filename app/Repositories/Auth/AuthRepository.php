<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

use App\Models\User;

class AuthRepository
{
    public function createUser(array $attributes): User
    {
        return User::create($attributes);
    }
}
