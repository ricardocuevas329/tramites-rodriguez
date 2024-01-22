<?php

namespace App\Http\Requests\Mantenimiento\BancoDeposito;

use Illuminate\Foundation\Http\FormRequest;

class StoreBancoDepositoRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_nombre" => 'required|max:255',
            "s_contable" => 'required|max:255',
            "s_descripcion" =>'nullable|max:255',
            "s_tipo" => 'required|max:1',
        ];
    }
}
