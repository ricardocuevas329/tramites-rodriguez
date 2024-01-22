<?php

namespace App\Dtos\Condicion;

use App\Http\Requests\ExtraProtocolar\Condicion\StoreCondicionRequest;
use App\Http\Requests\ExtraProtocolar\Condicion\UpdateCondicionRequest;

class CondicionDto
{
    public function __construct(
       public readonly ?Int $id,
      public readonly ?string $nombre,
      public readonly ?string $id_cnl,
      public readonly ?Int $estado,
    ){}
        
        public static function fromApiRequest(StoreCondicionRequest|UpdateCondicionRequest  $request): CondicionDto
        {
            return new self(
            id: $request->validated('id'),
            nombre: $request->validated('nombre'),
            id_cnl: $request->validated('id_cnl'),
            estado: $request->validated('estado'),
    );
}

}