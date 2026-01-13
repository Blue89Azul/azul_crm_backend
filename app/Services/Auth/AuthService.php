<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\UserRole;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\InvitationCodes\InvitationCodesRepository;
use App\Repositories\Tenant\TenantRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AuthService
{
    public function __construct(
        protected AuthRepository $authRepository,
        protected InvitationCodesRepository $invitationCodeRepository,
        protected TenantRepository $tenantRepository
    ) {}

    public function signupByAdmin(
        string $account,
        string $email,
        string $password,
    ): array {
        $now = now();

        if ($this->tenantRepository->hasSameAccount($account)) {
            throw new InvalidArgumentException("このアカウントはすでに使用されています");
        }

        $newAccount = $this->tenantRepository->createAccount($account);

        try {
            tenancy()->initialize($newAccount);

            if ($this->authRepository->existsByEmail($email)) {
                throw new InvalidArgumentException("このメールアドレスはすでに使用されています。");
            }

            $user = $this->authRepository->createUser([
                'email'           => $email,
                'password'        => $password,
                'user_role_id'    => UserRole::ADMIN->getId(),
                'created_at'      => $now,
                'updated_at'      => $now,
                'loggedin_at'     => $now,
            ]);

            tenancy()->end();
        } catch (Exception $e) {
            tenancy()->end();
            $newAccount->delete();
            throw new InvalidArgumentException($e->getMessage());
        }

        return [
            'account' => $newAccount,
            'user'    => $user
        ];
    }

    public function signupByMember(
        string $account,
        string $email,
        string $password,
        string $code
    ) {
        // テナントが存在するか確認
        if (!$this->tenantRepository->hasSameAccount($account)) {
            throw new InvalidArgumentException("指定されたアカウントが存在しません。");
        }

        $currentAccount = $this->tenantRepository->findByAccount($account);

        // 当該アカウントのテナントにアクセス
        tenancy()->initialize($account);

        $now = now();
        try {
            $invitationCode = $this->invitationCodeRepository->fetchByCode($code);
            if (is_null($invitationCode)) {
                throw new InvalidArgumentException("無効な招待コードです。");
            }

            $this->invitationCodeRepository->updateRedeemedAtById($invitationCode->id, $now);
            $user = $this->authRepository->createUser([
                'email'              => $email,
                'password'           => $password,
                'user_role_id'       => UserRole::MEMBER->getId(),
                'invitation_code_id' => $invitationCode->id,
                'created_at'         => $now,
                'updated_at'         => $now,
                'loggedin_at'        => $now,
            ]);
            tenancy()->end();
        } catch (Exception $e) {
            tenancy()->end();
            throw new InvalidArgumentException($e->getMessage());
        }

        return [
            'account' => $currentAccount,
            'user'    => $user
        ];
    }
}
