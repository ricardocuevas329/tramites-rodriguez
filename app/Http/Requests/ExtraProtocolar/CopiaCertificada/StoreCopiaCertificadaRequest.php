<?php

namespace App\Http\Requests\ExtraProtocolar\CopiaCertificada;

use Illuminate\Foundation\Http\FormRequest;

class StoreCopiaCertificadaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'd_fecha_legalizado' => 'required',
            'i_copias' => 'required',
            'i_inicial' => 'required',
            's_cargo' => 'required',
            's_consta' => 'required',
            's_descripcion' => 'required',
            's_folios' => 'required',
            's_legalizado' => 'required',
            's_libros' => 'required',
            's_numero_reg' => 'required',
            's_observacion' => 'nullable',
            's_pertenece' => 'required'
        ];
    }
}
