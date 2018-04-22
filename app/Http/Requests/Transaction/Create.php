<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Create
 * @package App\Http\Requests\Transaction
 * @property float amount
 * @property int wallet_id
 * @property int store_id
 * @property int service_id
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
            'amount' => ['required', 'numeric'],
            'wallet_id' => ['required', 'integer'],
            'store_id' => ['integer'],
            'service_id' => ['integer']
        ];
    }
}
