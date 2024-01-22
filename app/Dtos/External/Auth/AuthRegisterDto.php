<?php

namespace App\Dtos\External\Auth;

use App\Http\Requests\External\Auth\StoreRegisterRequest;

class AuthRegisterDto
{
    public function __construct(
        public readonly ?string $id_tipo_documento,
        public readonly ?string $email,
        public readonly ?string $documento,
        public readonly ?string $nombres,
        public readonly ?string $paterno,
        public readonly ?string $materno,
        public readonly ?string $numero,
        public readonly ?string $password1,
        public readonly ?bool   $accept,
    )
    {
    }

    public function toArray(): array
    {
        return [
            // client
            's_correo' => $this->email,
            'id_tipo_documento' => $this->id_tipo_documento,
            's_tipoDocu' => $this->id_tipo_documento,
            's_num_doc' => $this->documento,
            's_nombres' => $this->nombres,
            's_paterno' => $this->paterno,
            's_materno' => $this->materno,
            's_celular' => $this->numero,
            's_telefono' => $this->numero,
            's_pass' => $this->password1,
            'accept' => $this->accept,

            // empresa
            's_tip_doc' => $this->id_tipo_documento,
            's_nombre' => $this->nombres,
            's_email' => $this->email,
        ];
    }


    public static function fromApiRequest(StoreRegisterRequest $request): AuthRegisterDto
    {
        return new self(
            id_tipo_documento: $request->validated('id_tipo_documento'),
            email: $request->validated('email'),
            documento: $request->validated('documento'),
            nombres: $request->validated('nombres'),
            paterno: $request->validated('paterno'),
            materno: $request->validated('materno'),
            numero: $request->validated('numero'),
            password1: $request->validated('password1'),
            accept: $request->validated('accept'),
        );
    }

}
