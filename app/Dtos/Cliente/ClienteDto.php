<?php

namespace App\Dtos\Cliente;

use App\Http\Requests\Entidad\Cliente\StoreClienteRequest;
use App\Http\Requests\Entidad\Cliente\UpdateClienteRequest;

class ClienteDto
{
    public function __construct(
        public readonly ?string $s_paterno,
        public readonly ?string $s_materno,
        public readonly ?string $s_nombres,
        public readonly ?string $s_num_doc = '',
        public readonly ?string $d_fecha_nac,
        public readonly ?string $s_estado_civil,
        public readonly ?string $s_nacionalidad,
        public readonly ?string $s_localidad,
        public readonly ?string $s_direccion,
        //public readonly ?string $s_referencia ='',
        public readonly ?string $s_sexo,
        public readonly ?string $s_correo = '',
        //public readonly ?string $s_telefono ='',
        //public readonly ?string $s_celular ='',
        //public readonly ?string $s_pass = '',
        /*public readonly ?string $s_profesion = '',
        public readonly ?string $s_otro_profesion = '',
        public readonly ?string $s_cargo = '',
        public readonly ?string $s_otro_cargo = '',*/
        //public readonly ?Int $i_residencia = 0,
        public readonly ?string $id_tipo_documento = '',
        public readonly ?string $s_tipoDocu = '',

    ) {
    }
    public function toArray()
    {
        return [
            'd_fecha_nac' => $this->d_fecha_nac,
            //'i_residencia' => $this->i_residencia,
            //'s_cargo' => $this->s_cargo,
            //'s_celular' => $this->s_celular,
            's_correo' => $this->s_correo,
            's_direccion' => $this->s_direccion,
            's_estado_civil' => $this->s_estado_civil,
            's_localidad' => $this->s_localidad,
            's_materno' => $this->s_materno,
            's_nacionalidad' => $this->s_nacionalidad,
            's_nombres' => $this->s_nombres,
            's_num_doc' => $this->s_num_doc,
            //'s_otro_cargo' => $this->s_otro_cargo,
            //'s_otro_profesion' => $this->s_otro_profesion,
            //'s_pass' => $this->s_pass,
            's_paterno' => $this->s_paterno,
            //'s_profesion' => $this->s_profesion,
            //'s_referencia' => $this->s_referencia,
            's_sexo' => $this->s_sexo,
            //'s_telefono' => $this->s_telefono,
            'id_tipo_documento' => $this->id_tipo_documento,
            's_tipoDocu' => $this->id_tipo_documento,
        ];
    }

    public static function fromApiRequest(StoreClienteRequest|UpdateClienteRequest  $request): ClienteDto
    {
        return new self(
            d_fecha_nac: $request->validated('d_fecha_nac'),
            //i_residencia: $request->validated('i_residencia'),
            //s_cargo: $request->validated('s_cargo'),
            //s_celular: $request->validated('s_celular'),
            s_correo: $request->validated('s_correo'),
            s_direccion: $request->validated('s_direccion'),
            s_estado_civil: $request->validated('s_estado_civil'),
            s_localidad: $request->validated('s_localidad'),
            s_materno: $request->validated('s_materno'),
            s_nacionalidad: $request->validated('s_nacionalidad'),
            s_nombres: $request->validated('s_nombres'),
            s_num_doc: $request->validated('s_num_doc'),
            //s_otro_cargo: $request->validated('s_otro_cargo'),
            //s_otro_profesion: $request->validated('s_otro_profesion'),
            //s_pass: $request->validated('s_pass'),
            s_paterno: $request->validated('s_paterno'),
            //s_profesion: $request->validated('s_profesion'),
           //s_referencia: $request->validated('s_referencia'),
            s_sexo: $request->validated('s_sexo'),
            //s_telefono: $request->validated('s_telefono'),
            id_tipo_documento: $request->validated('id_tipo_documento'),
            s_tipoDocu: $request->validated('id_tipo_documento'),
        );
    }
}
