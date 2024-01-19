<?php

namespace App\Http\Requests\LomPost;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lom_name' => 'string',
            'post_link' => 'string',
            'post_type' => 'string',
            //'post_date' => 'string'
        ];
    }
}
