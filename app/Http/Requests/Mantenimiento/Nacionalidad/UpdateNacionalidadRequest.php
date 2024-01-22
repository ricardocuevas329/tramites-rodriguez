<?php

namespace App\Http\Requests\Mantenimiento\Nacionalidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNacionalidadRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    { 
        return [
            's_codigo_sbs' => 'required|max:3',
            's_gentilicio' => 'required|min:3|max:50',
            's_pais' => [
                'required' , Rule::unique('nacionalidad', 's_pais')->ignore($this->nacionalidad->s_codigo, 's_codigo') ,'max:50'
            ],
        ];
    }
}
