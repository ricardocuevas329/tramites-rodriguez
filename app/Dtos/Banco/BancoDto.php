<?php

namespace App\Dtos\Banco;

use App\Http\Requests\Administracion\Banco\StoreBancoRequest;
use App\Http\Requests\Administracion\Banco\UpdateBancoRequest;

class BancoDto
{
    public function __construct(
 
      public readonly ?string $s_cod_pdt,
      public readonly ?string $s_cod_cnl,
      public readonly ?string $s_nombre,
      public readonly ?string $s_abrev,
     
    ){}
        
        public static function fromApiRequest(StoreBancoRequest|UpdateBancoRequest  $request): BancoDto
        {
            return new self(
      
            s_cod_pdt: $request->validated('s_cod_pdt'),
            s_cod_cnl: $request->validated('s_cod_cnl'),
            s_nombre: $request->validated('s_nombre'),
            s_abrev: $request->validated('s_abrev'),
           
    );
}

}