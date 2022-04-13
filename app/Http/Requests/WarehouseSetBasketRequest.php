<?php

namespace App\Http\Requests;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WarehouseSetBasketRequest extends FormRequest
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
            'postman_id' => 'required|exists:postmen,id',
            'product_id' => 'required|exists:products,id',
            'count' => 'required|integer',
            'code' => 'required|exists:product_codes,code'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(BaseController::error($validator->errors()->first(), 422));
    }
}
