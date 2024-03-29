<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginFormRequest extends FormRequest
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
        return [
            'email' => 'required|exists:users',
            'password' => 'required',
        ];
    }

    public function authenticate()
    {
        $credentials = $this->only('email', 'password', 'business_id');

        $remember = request()->filled('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            return auth()->user();
        } else {
            return false;
        }
    }
}
