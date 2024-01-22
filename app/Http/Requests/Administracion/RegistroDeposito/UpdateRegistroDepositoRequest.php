<?php

namespace App\Http\Requests\Administracion\RegistroDeposito;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistroDepositoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tipo_kardex' => 'required',
            's_kardex' => 'required',
            's_tipo' => 'required',
            's_banco' => 'required',
            'd_fecha_ope' => 'required',
            's_num_ope' => 'required',
            'i_monto' => 'required',
            'fotos' => 'nullable',
            'banco_name' =>  'required',
        ];
    }
}
