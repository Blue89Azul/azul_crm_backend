<?php

declare(strict_types=1);

namespace App\Repositories\InvitationCodes;

use App\Models\InvitationCode;
use Carbon\Carbon;

class InvitationCodesRepository
{
    public function fetchAll()
    {
        return InvitationCode::all();
    }

    public function fetchByCode(string $code)
    {
        return InvitationCode::where('code', $code)->first();
    }

    public function updateRedeemedAtById(int $id, Carbon $now)
    {
        return InvitationCode::where('id', $id)->update(['redeemed_at' => $now]);
    }

    public function createNewCode(array $attributes): InvitationCode
    {
        return InvitationCode::create($attributes);
    }
}
