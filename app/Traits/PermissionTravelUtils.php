<?php
namespace App\Traits;

trait PermissionTravelUtils
{
   /**
    * Return a string response.
    *
    * @param  int  $id
    * @return string
    */

    function getNameParticipatesAs(int $id): string {

        return match ($id) {
            1 => 'PADRE',
            2 => 'MADRE',
            3 => 'HIJO',
            4 => 'CLIENTE',
            5 => 'SOLICITANTE',
            6 => 'REPRESENTANTE',
            7 => 'ACOMPAÑANTE',
            default => 'DESCONOCIDO',
        };
    }

    function getNameTipoTravelAs(int $id): string {

        return match ($id) {
            1 => 'INTERIOR DEL PAÍS',
            2 => 'EXTERIOR DEL PAÍS',
            default => 'Otro',
        };
    }

    function getNameTransportAs(int $id): string {

        return match ($id) {
            1 => 'TERRESTRE',
            2 => 'AÉREA',
            3 => 'MARÍTIMO',
            default => 'OTRO',
        };
    }

    function getNameAloneComponay(int|string $id): string {

        return match ($id) {
            1 => 'SOLO',
            0 => 'ACOMPAÑADO',
            'solo' => 'SOLO',
            'acompanado' => 'ACOMPAÑADO',
            'acompañado' => 'ACOMPAÑADO',
            default => 'OTRO',
        };
    }


    function getNameRetorno(int $id): string {

        return match ($id) {
            1 => 'SI',
            0 => 'NO',
            default => 'OTRO',
        };
    }

    function getNameFormats(int $id): string {

        return match ($id) {
            1 => 'CON PODER',
            2 => 'RECONOCIDO',
            3 => 'PADRE AUSENTE',
            4 => 'SIN FORMATO',
            default => 'OTRO',
        };
    }


}


