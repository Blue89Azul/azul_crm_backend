<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN  = "admin";
    case MEMBER = "member";

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isMember(): bool
    {
        return $this === self::MEMBER;
    }
}
