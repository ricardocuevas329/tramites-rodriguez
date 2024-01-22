<?php

namespace App\Http\Requests\Mantenimiento\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
                'required' , Rule::unique('roles', 'name')->ignore($this->permission->id, 'id') ,'max:100'
            ], 
        ];
    }
}
