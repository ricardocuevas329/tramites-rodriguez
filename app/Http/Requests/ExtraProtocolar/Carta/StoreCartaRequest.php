<?php

namespace App\Http\Requests\ExtraProtocolar\Carta;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {
        return [
             's_remitente' => 'required|max:10',
             's_referente' => 'required|max:10',
             's_facturado' => 'required|max:10',
             'destinatarios' => 'required|array',
             'formRemitente' => 'required|array',
             's_observacion' => 'nullable|max:255',
             'i_tipopago' => 'nullable|max:1',
             'i_delivery' => 'nullable|max:1',
             'i_bajopuerta' => 'nullable|max:1',
             'i_urgente' => 'nullable|max:1',
            'facturado_correo' => 'email|required|max:100',
            'facturado_telefono' => 'required|max:40',

        ];
    }

}
