<?php

namespace App\Http\Requests\Lom;

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
            'url' => 'string',
            'follower_id' => 'unsignedBigInteger',
            'follower_name' => 'string',
            'follower_job' => 'string',
            'friends' => 'string',
            'followers' => 'string'
        ];
    }
}
