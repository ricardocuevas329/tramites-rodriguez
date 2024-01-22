<?php

namespace App\Http\Requests\External\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "id_tipo_documento" => "required",
            "documento" => "required",
            "nombres" => "required|alpha_spaces",
            "paterno" => "nullable|alpha_spaces",
            "materno" => "nullable|alpha_spaces",
            "numero" => "required",
            "password1" => "required",
            "accept" => "required",
            "email" => "required|email|indisposable"
        ];
    }
}
