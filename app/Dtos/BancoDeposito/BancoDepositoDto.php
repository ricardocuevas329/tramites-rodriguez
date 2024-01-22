<?php

namespace App\Dtos\BancoDeposito;

use App\Http\Requests\Mantenimiento\BancoDeposito\StoreBancoDepositoRequest;
use App\Http\Requests\Mantenimiento\BancoDeposito\UpdateBancoDepositoRequest;

class BancoDepositoDto
{
  public function __construct(

    public readonly ?string $s_nombre,
    public readonly ?string $s_contable,
    public readonly ?string $s_descripcion,
    public readonly ?string $s_tipo,

  ) {
  }

  public static function fromApiRequest(StoreBancoDepositoRequest|UpdateBancoDepositoRequest  $request): BancoDepositoDto
  {
    return new self(
      s_nombre: $request->validated('s_nombre'),
      s_contable: $request->validated('s_contable'),
      s_descripcion: $request->validated('s_descripcion'),
      s_tipo: $request->validated('s_tipo'),
    );
  }
}
