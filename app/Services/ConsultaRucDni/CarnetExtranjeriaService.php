<?php

namespace App\Services\ConsultaRucDni;

 
class CarnetExtranjeriaService
{

 

    public function find(string $ce, string $tipo_doc)
    {
         if($ce){
            $ch = curl_init();
            $url =  'https://api.dniruc.com/api/search/ce/'.$ce .'/'.config('app.TOKEN_DNI_RUC');
            
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $respuesta = curl_exec($ch);

            if (curl_errno($ch)) {
                return 'Error en la petición cURL: ' . curl_error($ch);
            }

            curl_close($ch);

            if ($respuesta) {
                $data = json_decode($respuesta);
                if($data->data->nombres){
                 
                    return  [
                        's_paterno' =>   $data->data->ap_paterno,
                        's_materno' =>   $data->data->ap_materno,
                        's_nombres' =>   $data->data->nombres,
                        's_tipoDocu' =>   $tipo_doc,
                        'id_tipo_documento' =>   $tipo_doc,
                        's_num_doc' =>   $data->data->ce,
                        'nombre_compuesto' => $data->data->nombres .' ' .$data->data->ap_paterno.' ' .$data->data->ap_materno
                    ];
                }
              
            } else {
                return 'No se recibió una respuesta válida del servidor.';
            }
         }
       
    }

 
}
