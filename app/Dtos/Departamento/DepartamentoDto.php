<?php

namespace App\Dtos\Departamento;

use App\Http\Requests\Mantenimiento\Departamento\StoreDepartamentoRequest;
use App\Http\Requests\Mantenimiento\Departamento\UpdateDepartamentoRequest;

class DepartamentoDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_departamento,
    ){}
        
        public static function fromApiRequest(StoreDepartamentoRequest|UpdateDepartamentoRequest  $request): DepartamentoDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_departamento: $request->validated('s_departamento'),
    );
}

}