<?php

namespace App\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class LoginUserRequest extends FormRequest
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
    public function rules() : array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $example = [
            'email' => 'example@mail.ru',
            'password' => 'Password123!',
        ];
        throw new HttpResponseException(response()->json(['errors' => $errors, 'example' => $example], 422));
    }
}
