<?php

namespace App\Http\Requests;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class WarehouseAddOrder extends FormRequest
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
            'basket_id' => 'required|exists:warehouse_baskets,id',
            'orders' => 'required|array',
            'orders.*.product_id' => 'required|exists:products,id',
            'orders.*.count' => 'required',
            'orders.*.price' => 'required',
            'orders.*.unit' => [
                'required',
                Rule::in(['USD', 'UZS']),
            ],
            'orders.*.description' => 'nullable',
        ];

    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(BaseController::error($validator->errors()->first(), 422));
    }
}
