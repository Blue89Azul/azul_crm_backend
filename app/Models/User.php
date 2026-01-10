<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $attributes = [
        'name_last'   => '',
        'name_first'  => '',
    ];

    protected $fillable = [
        'email',
        'password',
        'name_last',
        'name_first',
        'user_role_id',
        'invitation_code_id',
        'organization_id',
        'loggedin_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password'    => 'hashed',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
            'loggedin_at' => 'datetime',
        ];
    }

    public function invitationCode()
    {
        return $this->hasOne(InvitationCode::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
