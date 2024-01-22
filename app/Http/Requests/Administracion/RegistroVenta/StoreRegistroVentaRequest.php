<?php

namespace App\Http\Requests\Administracion\RegistroVenta;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroVentaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'detail_services' => 'required',
            'invoice' => 'required',
            'sales' => 'required',
           
        ];
    }
}
