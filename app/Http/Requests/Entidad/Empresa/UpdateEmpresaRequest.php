<?php

namespace App\Http\Requests\Entidad\Empresa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            's_tip_doc' => 'required|max:8',
            's_nombre' => 'required|min:3|max:250',
            's_num_doc' =>'required|min:3|max:20',
            's_direccion' => 'required|min:1|max:500',
            's_email' => [
                'nullable' , Rule::unique('empresa', 's_email')->ignore($this->company->s_codigo, 's_codigo') ,'max:100'
            ],
        ];
    }
}
