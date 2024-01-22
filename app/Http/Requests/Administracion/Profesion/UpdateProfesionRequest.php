<?php

namespace App\Http\Requests\Administracion\Profesion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfesionRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
      
    
    public function rules()
    {
        return [
            's_nombre' => [
                'required' , Rule::unique('acciones', 's_nombre')->ignore($this->accion->i_codigo, 'i_codigo') ,'max:120'
            ],
            's_descripcion' => 'nullable|max:255',
            's_codper' => [
                'required' , Rule::unique('acciones', 's_codper')->ignore($this->accion->i_codigo, 'i_codigo') ,'max:4'
            ],

            
        ];

        
    }
   
}
