<?php

namespace App\Http\Requests\Entidad\DetalleBloqueado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetalleBloqueadoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_codreg_bloq' => 'required|max:12',
            's_compareciente'=> 'required|max:12',
            's_nombres'=> 'required|max:125',
            's_paterno'=> 'required|max:50',
            's_materno'=> 'required|max:50',
        ];
    }
}
