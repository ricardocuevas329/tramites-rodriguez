<?php

namespace App\Http\Requests\Mantenimiento\Estado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_codigo_sbs" => 'nullable|max:5',
            "s_tipo" => 'required|max:10',
            "s_desc" =>'nullable|max:255',
        ];
    }
}
