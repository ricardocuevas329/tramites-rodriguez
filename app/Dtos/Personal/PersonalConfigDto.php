<?php

namespace App\Dtos\Personal;

use App\Http\Requests\Entidad\Personal\UpdatePersonalConfigRequest;

class PersonalConfigDto
{
  public function __construct(
    public readonly ?string $s_frase,
     public readonly ?string $s_foto_fondo,
  ) {
  }
  public function toArray()
  {
    return [
      's_frase' => $this->s_frase,
      's_foto_fondo' => $this->s_foto_fondo,
    ];
  }

  public static function fromApiRequest(UpdatePersonalConfigRequest  $request): PersonalConfigDto
  {
    return new self(
      s_frase: $request->validated('s_frase'),
      s_foto_fondo: $request->validated('s_foto_fondo'),
    );
  }
}
