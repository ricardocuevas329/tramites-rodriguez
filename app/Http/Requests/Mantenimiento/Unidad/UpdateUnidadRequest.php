<?php

namespace App\Http\Requests\Mantenimiento\Unidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnidadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_nombre' => [
                'required' , Rule::unique('unidades', 's_nombre')->ignore($this->unidad->s_codigo, 's_codigo') ,'max:80'
            ],
            's_abrev'=> 'required|min:1|max:10',
            's_observacion'=> 'nullable|max:200',
        ];
    }
}
