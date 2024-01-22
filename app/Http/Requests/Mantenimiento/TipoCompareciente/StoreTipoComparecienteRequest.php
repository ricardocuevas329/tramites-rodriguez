<?php

namespace App\Http\Requests\Mantenimiento\TipoCompareciente;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoComparecienteRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_nombre" => 'required|min:3|max:255',
            "s_codigo_sg" => 'nullable|max:50',
            "s_tipo_pdt" =>'nullable|max:50',
            "s_color" => 'nullable|max:255',
            "s_clase" => 'nullable|max:11',
        ];
    }
}
