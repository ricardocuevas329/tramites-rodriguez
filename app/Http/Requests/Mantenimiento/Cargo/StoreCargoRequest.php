<?php

namespace App\Http\Requests\Mantenimiento\Cargo;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            's_nombre' => 'required|min:2|max:50',
            's_descripcion'=> 'nullable|max:100',
        ];
    }
}
