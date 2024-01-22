<?php

namespace App\Http\Requests\ExtraProtocolar\DiligenciaCarta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDiligenciaCartaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {
        return [
            's_num_carta' => 'unique:diligencia_carta,s_num_carta|required|max:10',
            's_recibido_por' => 'required|max:50',
            's_recibido_dni' => 'required|max:20',
            's_relacion_destinatario' => 'nullable|max:50',
            'inmueble' => 'required|max:30',
            's_pisos' => 'nullable|max:50',
            's_color' => 'nullable|max:50',
            's_puertas' => 'nullable|max:50',
            's_ventanas' => 'nullable|max:50',
            's_proyeccion' => 'nullable|max:50',
            's_observacion' => 'nullable|max:50',
            'fotos' => 'nullable|array',
       ];
    }

}
