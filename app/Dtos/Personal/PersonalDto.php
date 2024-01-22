<?php

namespace App\Dtos\Personal;

use App\Http\Requests\Entidad\Personal\StorePersonalRequest;
use App\Http\Requests\Entidad\Personal\UpdatePersonalRequest;

class PersonalDto
{
  public function __construct(
    public readonly ?string $d_fechaNacimiento,
     public readonly ?string $s_anexo_tra,
    public readonly ?string $s_barra,
    public readonly ?string $s_celular,
    public readonly ?string $s_celular_tra,
    public readonly ?string $s_correo_tra,
    public readonly ?string $s_direccion,
    public readonly ?string $s_distrito,
    public readonly ?string $s_estadoCivil,
    public readonly ?string $s_mail,
    public readonly ?string $s_materno,
    public readonly ?string $s_nacionalidad,
    public readonly ?string $s_nombre_seg,
    public readonly ?string $s_nombres,
    public readonly ?string $s_numero,
    public readonly ?string $s_observacion,
    public readonly ?string $s_paterno,
    public readonly ?string $s_sexo,
    public readonly ?string $s_telefono,
    public readonly ?string $s_telefono_tra,
    public readonly ?string $s_tipoDocu,
    public readonly ?string $s_user,
    public readonly ?array $roles,
    public readonly ?array $permissions,
    public readonly ?string $s_pass,
    public readonly ?string $estado_civil,
  ) {
  }
  public function toArray()
  {
    return [
      'd_fechaNacimiento' => $this->d_fechaNacimiento,
      's_anexo_tra' => $this->s_anexo_tra,
      's_barra' => $this->s_barra,
      's_celular' => $this->s_celular,
      's_celular_tra' => $this->s_celular_tra,
      's_correo_tra' => $this->s_correo_tra,
      's_direccion' => $this->s_direccion,
      's_distrito' => $this->s_distrito,
      's_estadoCivil' => $this->s_estadoCivil,
      's_mail' => $this->s_mail,
      's_materno' => $this->s_materno,
      's_nacionalidad' => $this->s_nacionalidad,
      's_nombre_seg' => $this->s_nombre_seg,
      's_nombres' => $this->s_nombres,
      's_numero' => $this->s_numero,
      's_observacion' => $this->s_observacion,
      's_paterno' => $this->s_paterno,
      's_sexo' => $this->s_sexo,
      's_telefono' => $this->s_telefono,
      's_telefono_tra' => $this->s_telefono_tra,
      's_tipoDocu' => $this->s_tipoDocu,
      's_user' => $this->s_user,
      'roles' => $this->roles,
      'permissions' => $this->permissions,
      's_pass' => $this->s_pass,
      'estado_civil' => $this->estado_civil,
    ];
  }

  public static function fromApiRequest(StorePersonalRequest|UpdatePersonalRequest  $request): PersonalDto
  {
    return new self(
      d_fechaNacimiento: $request->validated('d_fechaNacimiento'),
      s_anexo_tra: $request->validated('s_anexo_tra'),
      s_barra: $request->validated('s_barra'),
      s_celular: $request->validated('s_celular'),
      s_celular_tra: $request->validated('s_celular_tra'),
      s_correo_tra: $request->validated('s_correo_tra'),
      s_direccion: $request->validated('s_direccion'),
      s_distrito: $request->validated('s_distrito'),
      s_estadoCivil: $request->validated('s_estadoCivil'),
      s_mail: $request->validated('s_mail'),
      s_materno: $request->validated('s_materno'),
      s_nacionalidad: $request->validated('s_nacionalidad'),
      s_nombre_seg: $request->validated('s_nombre_seg'),
      s_nombres: $request->validated('s_nombres'),
      s_numero: $request->validated('s_numero'),
      s_observacion: $request->validated('s_observacion'),
      s_paterno: $request->validated('s_paterno'),
      s_sexo: $request->validated('s_sexo'),
      s_telefono: $request->validated('s_telefono'),
      s_telefono_tra: $request->validated('s_telefono_tra'),
      s_tipoDocu: $request->validated('id_tipo_documento'),
      s_user: $request->validated('s_user'),
      roles: $request->validated('roles'),
      permissions: $request->validated('permissions'),
      s_pass: $request->validated('s_pass'),
      estado_civil: $request->validated('estado_civil'),
    );
  }
}
