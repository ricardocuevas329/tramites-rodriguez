<?php

namespace App\Http\Requests\ExtraProtocolar\Participante;

use App\Enums\ParticipantItems;
use Illuminate\Foundation\Http\FormRequest;

class StoreParticipanteRequest extends FormRequest
{
    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'i_condicion' => 'required',
            'i_firma' => 'required',
            'i_permiso' => 'nullable',
            's_edad' => 'required',
            's_observacion' => 'nullable',
            's_participante' => 'nullable',
            's_partida' => 'required_if:i_condicion,6',
            's_sede_reg' => 'required_if:i_condicion,6',
            'cliente' => 'nullable',
        ];
    }
}
