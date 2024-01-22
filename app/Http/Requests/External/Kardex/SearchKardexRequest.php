<?php

namespace App\Http\Requests\External\Kardex;

use Illuminate\Foundation\Http\FormRequest;

class SearchKardexRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'number_kardex' => '' ,
        ];
    }
}
