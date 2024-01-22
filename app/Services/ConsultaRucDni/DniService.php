<?php

namespace App\Services\ConsultaRucDni;

use App\Models\Entidad\Cliente;
use App\Traits\DateManipulation;
use DateTime;

class DniService
{
    use DateManipulation;


    public function find(string $dni, string $tipo_doc)
    {
        if ($dni) {

            $ch = curl_init();
            $url = 'https://api.dniruc.com/api/search/dni/' . $dni . '/' . config('app.TOKEN_DNI_RUC');

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $respuesta = curl_exec($ch);

            if (curl_errno($ch)) {
                //  . curl_error($ch)
                return 'Error en la petición cURL: ';
            }

            curl_close($ch);

            if ($respuesta) {
                $data = json_decode($respuesta);
                if ($data->data) {

                    if($data->data?->fecha_nacimiento){
                        $birthday = DateTime::createFromFormat('d/m/Y', $data->data?->fecha_nacimiento)->format('Y-m-d');
                    }else{
                        $birthday = date('Y-m-d H-i-s');
                    }

                    $cliente = new Cliente();
                    $cliente->s_paterno = $data->data->ap_paterno;
                    $cliente->s_materno = $data->data->ap_materno;
                    $cliente->s_nombres = $data->data->nombres;
                    $cliente->s_num_doc = $data->data->dni;
                    $cliente->d_fecha_nac = $birthday;
                    $cliente->s_estado_civil = $data->data->estadoCivil == '-' ? '' : $data->data->estadoCivil;
                    $cliente->s_localidad = $data->data->ubigeotext;
                    $cliente->s_direccion = $data->data->ubigeotext. '/' .$data->data->direccion;
                    $cliente->s_sexo = $data->data->sexo[0];
                    $cliente->s_tipoDocu = $tipo_doc;
                    $isSaved = $cliente->save();
                    if($isSaved){

                        return [
                            's_codigo' => $cliente->s_codigo,
                            's_paterno' => $data->data->ap_paterno,
                            's_materno' => $data->data->ap_materno,
                            's_nombres' => $data->data->nombres,
                            'id_tipo_documento' => $tipo_doc,
                            's_tipoDocu' => $tipo_doc,
                            's_num_doc' => $data->data->dni,
                            'd_fecha_nac' => $birthday,
                            's_estado_civil' => $data->data->estadoCivil == '-' ? '' : $data->data->estadoCivil,
                            //'s_nacionalidad' => $data->data,
                            's_localidad' => $data->data->ubigeotext,
                            's_direccion' => $data->data->ubigeotext. '/' .$data->data->direccion,
                            's_sexo' => $data->data->sexo[0],
                            'nombre_compuesto' => $data->data->nombre_completo
                        ];
                    }

                }

            } else {
                return 'No se recibió una respuesta válida del servidor.';
            }
        }
    }
}
