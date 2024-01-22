<?php

namespace App\Http\Requests\External\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'numero_documento' => 'required',
            'apellido_materno' => 'required',
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'tipo_documento' => 'required',
        ];
    }
}
