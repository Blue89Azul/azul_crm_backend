<?php

declare(strict_types=1);

namespace App\UseCases\InvitationCodes;

use App\Repositories\InvitationCodes\InvitationCodesRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class CreateNewCodeUseCase
{
    public function __construct(
        private InvitationCodesRepository $repository
    ) {}

    public function __invoke()
    {
        $user = Auth::user();
        $now  = now();
        return $this->repository->createNewCode([
            'created_by'      => $user->id,
            'role_id'         => $user->user_role_id,
            'expires_at'      => $now,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);
    }
}
