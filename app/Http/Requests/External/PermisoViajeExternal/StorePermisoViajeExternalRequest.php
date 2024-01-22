<?php

namespace App\Http\Requests\External\PermisoViajeExternal;

use Illuminate\Foundation\Http\FormRequest;

class StorePermisoViajeExternalRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'transport' => 'required' ,
            'route' => 'required' ,
            'obervation' => 'nullable|max:800' ,
            'type' => 'required' ,
            'clientes' => 'array|nullable' ,
            'participantes' => 'array|nullable' ,
            'travel' => 'required' ,
            'line' => 'nullable|max:120' ,
            'date_sal' => 'required|date' ,
            'date_ret' => 'nullable|date|after_or_equal:date_sal' ,
            'files' => 'array|nullable' ,
            'phone' => 'required|max:20',
            'email' => 'nullable|email|max:100',
        ];
    }
}
