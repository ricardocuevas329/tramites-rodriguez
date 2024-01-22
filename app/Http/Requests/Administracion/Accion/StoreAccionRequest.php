<?php

namespace App\Http\Requests\Administracion\Accion;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccionRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
      
    
    public function rules()
    {
        return [
             's_nombre' => 'unique:acciones,s_nombre|required|min:2|max:120',
             's_descripcion' => 'nullable|max:255',
             's_codper' => 'unique:acciones,s_codper|required|min:4|max:4',

             
        ];

        
    }
   
}
