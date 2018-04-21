<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Login
 * @package App\Http\Requests\Auth
 * @property string name
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
            'name' => ['required', 'exists:users', 'string', 'max:255', 'alpha_dash'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }
}
