<?php

namespace App\Http\Requests\Protocolar\Procurador\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcuradorDocument extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required',
            'name' => 'required',
            'size' => 'required',
            'type' => 'required',
        ];
    }
}
