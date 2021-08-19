<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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
            //
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();

        $response = new \Illuminate\Http\JsonResponse([
        'status' => false,
        'code' => 422,
        'message' => 'invalid_data',
        'data' => compact('errors')
    ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
