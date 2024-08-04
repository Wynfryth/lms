<?php

namespace App\Http\Requests;

use App\Models\ClassCat;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClassCat extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class_category' => ['required', 'string', 'max:255', 'unique' . ClassCat::class],
            'desc' => ['sometimes', 'string', 'max:255']
        ];
    }
}
