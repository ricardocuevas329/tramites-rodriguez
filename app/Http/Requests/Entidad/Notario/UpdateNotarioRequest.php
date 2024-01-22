<?php

namespace App\Http\Requests\Entidad\Notario;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotarioRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_tipodoc" => 'required|min:3|max:255',
            "s_numdoc" => 'required|min:3|max:255',
            "s_paterno" =>'required|min:3|max:255',
            "s_materno" => 'required|max:255',
            "s_nombres" => 'required|max:255',
            "s_cargo" => 'required|max:255',
            "s_sexo" => 'required|max:255',
            "s_telefonos" => 'nullable|max:255',
            "s_observacion" => 'nullable|max:255',
        ];
    }
}
