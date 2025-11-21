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
        $now = now();

        $this->repository->createNewCode([
            'created_by' => $user->id,
            'organization_id' => $user->organization_id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
