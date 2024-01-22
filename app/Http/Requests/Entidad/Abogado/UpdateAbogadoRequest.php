<?php

namespace App\Http\Requests\Entidad\Abogado;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAbogadoRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
      
    
    public function rules()
    {
        return [
            's_materno' => 'required|min:3|max:50',
             's_paterno' => 'required|min:3|max:50',
             's_nombres' => 'required|min:3|max:70',
             's_sexo' => 'required|min:1|max:10',
             's_telefono' => 'string|nullable|min:7|max:9',
             's_cal' => 'unique:abogado,s_cal|required|min:1|max:100',
             's_cal' => [
                'required' , Rule::unique('abogado', 's_cal')->ignore($this->abogado->s_codigo, 's_codigo') ,'max:100'
            ], 
             's_colegio' => 'required|min:2|max:15',
             's_personal' => 'min:0|max:12',
           
        ];

        
    }
   
}
