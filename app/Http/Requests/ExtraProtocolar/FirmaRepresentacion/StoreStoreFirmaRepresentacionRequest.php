<?php

namespace App\Http\Requests\ExtraProtocolar\FirmaRepresentacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreFirmaRepresentacionRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_representado' => 'required',
            's_cliente' => 'required',
            's_observacion' =>  'nullable|max:250',
        ];
    }
}
