<?php

namespace App\Http\Requests\Mantenimiento\DocumentoVenta;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoVentaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_nombre'=> 'required|max:50',
            's_abrev'=> 'required|max:6',
            's_serie'=> 'required|max:7',
            's_impresora'=> 'nullable|max:100',
            'id_tipo_comprobante'=> 'required|max:10',
        ];
    }
}
