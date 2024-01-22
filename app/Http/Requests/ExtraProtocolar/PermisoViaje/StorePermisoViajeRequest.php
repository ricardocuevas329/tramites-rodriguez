<?php

namespace App\Http\Requests\ExtraProtocolar\PermisoViaje;

use Illuminate\Foundation\Http\FormRequest;

class StorePermisoViajeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_transporte' => 'required',
            's_ruta' => 'required',
            's_observacion' => 'nullable|max:800',
            's_formato' => 'nullable',
            'i_tipo' => 'required',
            'i_solo' => 'nullable',
            'i_numero' => 'required',
            'con_quien_viaja' => 'required',
            's_linea' => 'nullable|max:120',
            'i_retorno' => 'required|max:10',
            'd_fecha_sal' => 'required|date',
            'd_fecha_ret' => 'nullable|date|after_or_equal:d_fecha_sal',
            'acompanantes' => 'array|nullable',
            'participantes' => 'array|nullable',
            'files' => 'array|nullable',
        ];
    }
}
