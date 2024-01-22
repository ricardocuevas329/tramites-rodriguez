<?php

namespace App\Http\Requests\ExtraProtocolar\Libro;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibroRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contado' => 'boolean',
            'correo' => 'required|email',
            'dni' => 'required',
            'dni_representa' => 'required|int',
            'libros_legalizados' => 'required|array',
            'observacion' => 'nullable|max:250',
            'ruc' => 'int',
            'ruc_facturado' => 'int',
            'telefono' => 'nullable|int',
            'dni_id_cod' => 'string',
            'ruc_id_cod' => 'string',
            'dni_representa_id_cod' => 'string',
            'ruc_facturado_id_cod' => 'string',
            'files' => 'array|nullable'
        ];
    }
}
