<?php

namespace App\Http\Requests\Mantenimiento\BancoDeposito;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBancoDepositoRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "s_nombre" => 'required|min:3|max:255',
            "s_contable" => 'required|min:3|max:255',
            "s_descripcion" =>'nullable|min:3|max:255',
            "s_tipo" => 'required|max:1',
        ];
    }
}
