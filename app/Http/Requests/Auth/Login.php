<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Login
 * @package App\Http\Requests\Auth
 * @property string email
 * @property string password
 */
class Login extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'exists:users', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ];
    }
}
