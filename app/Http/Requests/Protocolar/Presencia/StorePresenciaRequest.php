<?php

namespace App\Http\Requests\Protocolar\Presencia;

use Illuminate\Foundation\Http\FormRequest;

class StorePresenciaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'i_tipopago' => 'required',
            's_contacto' => 'required',
            's_facturado' => 'required',
            's_observacion' => 'required',
            's_referente' => 'required',
        ];
    }
}
