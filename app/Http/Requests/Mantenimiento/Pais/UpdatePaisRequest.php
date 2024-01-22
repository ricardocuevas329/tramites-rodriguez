<?php

namespace App\Http\Requests\Mantenimiento\Pais;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaisRequest extends FormRequest
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
            's_pais' => [
                'required' , Rule::unique('paises', 's_pais')->ignore($this->pais->s_codigo, 's_codigo') ,'max:50'
            ],
        ];
    }
}
