<?php

namespace App\Http\Requests\Mantenimiento\CargoPublico;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoPublicoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'codigo' => 'required|max:3',
            'descripcion' => 'required|min:3|max:255',
        ];
    }
}
