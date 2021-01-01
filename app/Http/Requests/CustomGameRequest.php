<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomGameRequest extends FormRequest
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
            'title' => 'required|min:2',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Un titre est obligatoire',
            'title.min' => 'Le titre doit avoir au moins 2 caractères',
        ];
    }
}
