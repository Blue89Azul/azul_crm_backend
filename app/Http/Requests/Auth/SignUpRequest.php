<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'email'    => ['required', 'email', 'unique|users'],
            'password' => ['required', 'string', 'unique|users', 'max|255'],
            'role'     => ['required', Rule::enum(UserRole::class)],
        ];

        /** @var \Illuminate\Foundation\Http\FormRequest|\Illuminate\Http\Request $this */
        $userRole = $this->input('role');

        if (UserRole::from($userRole)?->isMember()) {
            $rule['invitation_code'] = ['required', 'string', ];
        }

        return $rule;
    }
}
