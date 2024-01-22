<?php

namespace App\Dtos\DocumentoVenta;

use App\Http\Requests\Mantenimiento\DocumentoVenta\StoreDocumentoVentaRequest;
use App\Http\Requests\Mantenimiento\DocumentoVenta\UpdateDocumentoVentaRequest;

class DocumentoVentaDto
{
    public function __construct(
      public readonly ?Int $id_tipo_comprobante,
      public readonly ?string $s_abrev,
      public readonly ?string $s_impresora,
      public readonly ?string $s_nombre,
      public readonly ?string $s_serie,
    ){}
        
        public static function fromApiRequest(StoreDocumentoVentaRequest|UpdateDocumentoVentaRequest  $request): DocumentoVentaDto
        {
            return new self(
          
            id_tipo_comprobante: $request->validated('id_tipo_comprobante'),
            s_abrev: $request->validated('s_abrev'),
            s_impresora: $request->validated('s_impresora'),
            s_nombre: $request->validated('s_nombre'),
            s_serie: $request->validated('s_serie'),
    );
}

}