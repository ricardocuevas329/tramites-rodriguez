<?php

namespace App\Http\Requests\ExtraProtocolar\Libro;

use Illuminate\Foundation\Http\FormRequest;

class FilterLibroRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'max:100',
        ];
    }
}
