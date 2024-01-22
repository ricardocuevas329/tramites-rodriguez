<?php

namespace App\Http\Requests\Mantenimiento\ModoPago;

use Illuminate\Foundation\Http\FormRequest;

class StoreModoPagoRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_codigo_pdt" => 'nullable|max:5',
            "s_codigo_sbs" => 'nullable|max:2',
            "s_nombre" => 'required|min:3|max:120',
            "s_descripcion" =>'nullable|max:150',
        ];
    }
}
