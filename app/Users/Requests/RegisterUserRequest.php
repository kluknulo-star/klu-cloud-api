<?php

namespace App\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'name' => [
                'required',
                'max:70',
                "string"
            ],
            'email' => 'required|unique:users,email|email:rfc',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->symbols()
                    ->uncompromised()
                    ->numbers()
                    ->mixedCase(),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $example = [
            'name' => 'kirill',
            'email' => 'kluknulo@mail.ru',
            'password' => 'Kirillkirill1!',
            'password_confirmation' => 'Kirillkirill1!'
        ];
        throw new HttpResponseException(response()->json(['errors' => $errors, 'example' => $example], 422));
    }
}
