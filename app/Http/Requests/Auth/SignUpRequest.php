<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRole;
use App\Http\Responses\ApiErrorResponse;
use App\Rules\Auth\ValidInvitationCode;
use App\Rules\Auth\ValidPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'email'    => ['required', 'string', 'email:filter'],
            'account'  => ['required', 'string'],
            'password' => ['required', new ValidPassword],
            'role'     => ['required', Rule::enum(UserRole::class)],
        ];

        /** @var \Illuminate\Foundation\Http\FormRequest|\Illuminate\Http\Request $this */
        $userRole = $this->input('role');

        if (!is_null($userRole) && UserRole::from($userRole)->isMember()) {
            $rule['code'] = ['required'];
        }

        return $rule;
    }


    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiErrorResponse::make(
                'Invalid Parameter',
                $validator->errors()->first(),
                422,
            )->toResponse()
        );
    }
}
