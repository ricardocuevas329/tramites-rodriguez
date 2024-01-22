<?php

namespace App\Http\Requests\ExtraProtocolar\DiligenciaProgramada;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDiligenciaProgramadaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {
        return [
            'd_fecha_programacion' => 'required',
            's_num_carta' => 'required|max:10',
            's_motorizado' => 'required|max:8',
            's_observacion' => 'required|max:250',
       ];
    }

}
