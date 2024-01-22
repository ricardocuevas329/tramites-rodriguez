<?php

namespace App\Http\Requests\Administracion\Banco;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBancoRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
      
    
    public function rules()
    {
        return [
         
            's_cod_pdt' => 'required|min:2|max:5',
            's_cod_cnl' => 'required|min:2|max:5',
            's_nombre' => [
                'required' , Rule::unique('banco', 's_nombre')->ignore($this->banco->id_cod, 'id_cod') ,'max:50'
            ],
            's_abrev' => 'required|min:2|max:5',
            
        ];

        
    }
   
}
