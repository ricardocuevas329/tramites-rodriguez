<?php

namespace App\Http\Requests\Mantenimiento\Pais;

use Illuminate\Foundation\Http\FormRequest;

class StorePaisRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_gentilicio_m' => 'required|min:3|max:100',
            's_gentilicio_f' => 'required|min:3|max:100',
            's_pais' => 'unique:paises,s_pais|required|max:100',  
        ];
    }
}
