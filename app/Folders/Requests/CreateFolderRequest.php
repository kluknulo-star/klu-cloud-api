<?php

namespace App\Folders\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class CreateFolderRequest extends FormRequest
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
            'folder_name' => 'required|string',
            'user_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $example = [
            'folder_name' => 'myNewFolder',
        ];
        throw new HttpResponseException(response()->json(['errors' => $errors, 'example' => $example], 422));
    }
}
