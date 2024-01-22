<?php

namespace App\Http\Requests\Mantenimiento\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required' , Rule::unique('roles', 'name')->ignore($this->role->id, 'id') ,'max:100'
            ], 
        ];
    }
}
