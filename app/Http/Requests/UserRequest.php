<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('users', 'name')->ignore($this->user)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')->ignore($this->user)],
            'password' => ['nullable', Password::min(6)],
        ];
    }
}
