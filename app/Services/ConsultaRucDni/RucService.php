<?php

namespace App\Services\ConsultaRucDni;

use App\Models\Entidad\Empresa;

class RucService
{


    public function find(string $ruc, string $tipo_doc = '')
    {
        if ($ruc) {

            $ch = curl_init();
            $url = 'https://api.dniruc.com/api/search/ruc/' . $ruc . '/' . config('app.TOKEN_DNI_RUC');

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $respuesta = curl_exec($ch);

            if (curl_errno($ch)) {
                return 'Error en la petición cURL: ' . curl_error($ch);
            }

            curl_close($ch);

            if ($respuesta) {
                $data = json_decode($respuesta);
                if ($data->data) {
                    $empresa = new Empresa();
                    $empresa->s_direccion = $data->data->direccion;
                    $empresa->s_localidad = $data->data->distrito;
                    $empresa->s_nombre = $data->data->nombre_razon_social;
                    $empresa->s_num_doc = $data->data->ruc;
                    $empresa->s_objeto_social = $data->data->tipo;
                    $empresa->s_referencia = $data->data->calle;
                    $empresa->s_tip_doc = $tipo_doc;
                    $isSaved = $empresa->save();


                    if ($isSaved) {
                        return [
                            's_codigo' => $empresa->s_codigo,
                            's_direccion' => $data->data->direccion,
                            's_localidad' => $data->data->distrito,
                            's_nombre' => $data->data->nombre_razon_social,
                            's_nombre_compuesto' => $data->data->nombre_razon_social,
                            's_num_doc' => $data->data->ruc,
                            's_objeto_social' => $data->data->tipo,
                            's_referencia' => $data->data->calle,
                            's_tip_doc' => $tipo_doc,
                            'nombre_compuesto' => $data->data->nombre_razon_social,
                        ];

                    }
                }
            } else {
                return 'No se recibió una respuesta válida del servidor.';
            }
        }
    }
}
