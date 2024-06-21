<?php

namespace App\Http\Requests\Protocolar\Tramite;

use Illuminate\Foundation\Http\FormRequest;

class StoreObervation extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
           's_tramite' => 'required',
           's_observacion' => 'required|max:1000'
        ];
    }
}
