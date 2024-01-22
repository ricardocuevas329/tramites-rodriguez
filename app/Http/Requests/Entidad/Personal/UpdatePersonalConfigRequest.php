<?php

namespace App\Http\Requests\Entidad\Personal;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalConfigRequest extends FormRequest
{
 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_frase' => 'required|min:3|max:250',
            's_foto_fondo' => 'required|min:3|max:255',
            
        ];
    }
}
