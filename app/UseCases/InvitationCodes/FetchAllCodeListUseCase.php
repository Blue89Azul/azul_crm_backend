<?php

declare(strict_types=1);

namespace App\UseCases\InvitationCodes;

use App\Repositories\InvitationCodes\InvitationCodesRepository;
use Illuminate\Support\Collection;

final class FetchAllCodeListUseCase
{
    public function __construct(
        private InvitationCodesRepository $repository
    ) {}

    public function __invoke(): Collection
    {
        return $this->repository->fetchAll();
    }
}
