<?php

namespace App\Http\Requests\Mantenimiento\ZonaRegistral;

use Illuminate\Foundation\Http\FormRequest;

class StoreZonaRegistralRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            's_codigo_sbs' => 'required|max:2',
            's_nombre' => 'required|max:50',
        ];
    }
}
