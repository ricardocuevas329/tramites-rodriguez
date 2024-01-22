<?php

namespace App\Http\Requests\Administracion\Area;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
      
    
    public function rules()
    {
        return [
             's_nombre' => 'unique:area,s_nombre|required|max:30',
             's_descarea' => 'nullable|max:90',
        ];

        
    }
   
}
