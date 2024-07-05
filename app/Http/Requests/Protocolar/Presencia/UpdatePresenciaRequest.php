<?php

namespace App\Http\Requests\Protocolar\Presencia;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresenciaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'solicitante' => 'required',
            'empresa' => 'required',
            'contacto' => 'required',
            'details' => 'array',
        ];
    }
}
