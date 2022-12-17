<?php

namespace App\Files\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;


class TitleFileRequest extends FormRequest
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
            'file_title' => 'required|string',
            'user_id' => 'required|int',
            'folder_name' => 'optional|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $example = [
            'file_title' => 'filename.txt',
            'new_file_title' => 'newFilename.txt',
            'folder_title' => 'newFolder'
        ];
        throw new HttpResponseException(response()->json(['errors' => $errors, 'example_request' => $example], 422));
    }
}
