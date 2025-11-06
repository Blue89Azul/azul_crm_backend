<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitationCode extends Model
{
    protected $fillable = [
        'code',
        'role_id',
        'organization_id',
        'created_by',
        'redeemed_at',
        'expires_at',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateCode();
            }
        });
    }

    /**
     * Summary of generateCode
     * @return string
     */
    private static function generateCode()
    {
        do {
            $code = Str::random(24);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
