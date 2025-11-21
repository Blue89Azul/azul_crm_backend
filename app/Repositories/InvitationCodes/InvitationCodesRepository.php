<?php

declare(strict_types=1);

namespace App\Repositories\InvitationCodes;

use App\Models\InvitationCode;

class InvitationCodesRepository
{
    public function fetchPagenated(int $pageNumber)
    {
        return InvitationCode::paginate($pageNumber);
    }

    public function createNewCode(array $attributes)
    {
        InvitationCode::create($attributes);
    }
}
