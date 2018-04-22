<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Create
 * @package App\Http\Requests\Store
 * @property string name
 */
class Create extends FormRequest
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
            'name' => ['required', 'string', 'max:255']
        ];
    }
}
