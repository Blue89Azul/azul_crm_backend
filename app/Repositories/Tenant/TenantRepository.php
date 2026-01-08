<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantRepository
{
    public function createAccount(string $account)
    {
        return Tenant::create(['id' => $account]);
    }

    public function hasSameAccount(string $account)
    {
        return Tenant::where('id', $account)->exists();
    }

    public function findByAccount(string $account)
    {
        return Tenant::find($account);
    }
}
