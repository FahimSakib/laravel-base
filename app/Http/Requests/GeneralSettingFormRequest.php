<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralSettingFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'=>false,
                'errors'=> $validator->errors()
            ],200)
        );
    }
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
            'title'             => 'required|string',
            'address'           => 'required|string',
            'currency_code'     => 'required|string',
            'currency_code'     => 'required|string',
            'currency_position' => 'required|string',
            'timezone'          => 'string',
            'date_formate'      => 'string',
            'invoice_prefix'    => 'required|string',
            'invoice_number'    => 'required|string',
            'logo'              => 'required|image|mimes:png,jpg,jpeg,svg',
            'favicon'           => 'required|image|mimes:png',
        ];
    }
}