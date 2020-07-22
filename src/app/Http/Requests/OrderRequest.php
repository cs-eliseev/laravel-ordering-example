<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required|text_ru',
            'address' => 'required|address_ru',
            'phone' => 'required|phone_simple',
            'package' => 'required|integer',
            'delivery' => 'required|date',
            'price' => 'required',
        ];
    }
}
