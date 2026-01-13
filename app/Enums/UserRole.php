<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN  = "admin";
    case MEMBER = "member";

    // TODO: Fetch these data from DB
    public function getId()
    {
        return match ($this) {
            self::ADMIN => 1,
            self::MEMBER => 2,
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isMember(): bool
    {
        return $this === self::MEMBER;
    }
}
