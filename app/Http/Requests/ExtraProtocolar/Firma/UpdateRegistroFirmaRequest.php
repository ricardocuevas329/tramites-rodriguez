<?php

namespace App\Http\Requests\ExtraProtocolar\Firma;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistroFirmaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'd_caducidad' => 'required',
            's_cliente' => 'required',
            's_proceder' => 'required',
            'files' => 'array|nullable'
        ];
    }
}
