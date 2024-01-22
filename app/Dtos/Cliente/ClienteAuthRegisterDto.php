<?php

namespace App\Dtos\Cliente;


class ClienteAuthRegisterDto
{
    public function __construct(
        public readonly ?string $s_paterno,
        public readonly ?string $s_materno,
        public readonly ?string $s_nombres,
        public readonly ?string $s_num_doc,
        public readonly ?string $s_correo,
        public readonly ?string $id_tipo_documento,
        public readonly ?string $s_tipoDocu = '',
        public readonly ?string $numero,
        public readonly ?string $password1
    )
    {
    }

    public function toArray(): array
    {
        return [

            's_correo' => $this->s_correo,
            's_materno' => $this->s_materno,
            's_nombres' => $this->s_nombres,
            's_num_doc' => $this->s_num_doc,
            's_paterno' => $this->s_paterno,
            'id_tipo_documento' => $this->id_tipo_documento,
            's_tipoDocu' => $this->id_tipo_documento,
            's_celular' => $this->numero,
            's_pass' => $this->password1,
        ];
    }

}
