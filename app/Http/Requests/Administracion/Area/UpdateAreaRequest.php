<?php

namespace App\Http\Requests\Administracion\Area;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAreaRequest extends FormRequest
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
                'required' , Rule::unique('area', 's_nombre')->ignore($this->area->s_codigo, 's_codigo') ,'max:30'
            ],
            's_descarea' => 'nullable|max:90',
            

            
        ];

        
    }
   
}
