<?php

namespace App\Http\Requests\Mantenimiento\Requisito;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequisitoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_nombre' => 'required|min:2|max:100',
            's_descripcion'=> 'nullable|max:200',
        ];
    }
}
