<?php

namespace App\Http\Requests\ExtraProtocolar\Carta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateObservationCartaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {
        return [
            's_observacion' => 'nullable|max:255',
       ];
    }

}
