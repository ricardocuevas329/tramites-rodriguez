<?php

namespace App\Http\Requests\External\Kardex;

use Illuminate\Foundation\Http\FormRequest;

class StoreKardexAsignationRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'codigo' => 'required' ,
            'number_kardex' => 'required' ,
            'cod_client' => 'required' ,
        ];
    }
}
