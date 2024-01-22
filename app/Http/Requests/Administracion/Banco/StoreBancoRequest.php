<?php

namespace App\Http\Requests\Administracion\Banco;

use Illuminate\Foundation\Http\FormRequest;

class StoreBancoRequest extends FormRequest
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
            's_nombre' => 'unique:banco,s_nombre|required|min:2|max:60',
            's_abrev' => 'required|min:2|max:5',
        ];

        
    }
   
}
