<?php

namespace App\Dtos\Testimonio;
class TestimonioDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_kardex,
      public readonly ?string $s_cliente,
      public readonly ?string $s_documento,
      public readonly ?string $s_observacion,
      public readonly ?string $d_fecha_entrega,
      public readonly ?string $s_hora_registro,
      public readonly ?string $s_personal_reg,
      public readonly ?string $d_fecha_reg,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreTestimonioRequest|UpdateTestimonioRequest  $request): TestimonioDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_kardex: $request->validated('s_kardex'),
            s_cliente: $request->validated('s_cliente'),
            s_documento: $request->validated('s_documento'),
            s_observacion: $request->validated('s_observacion'),
            d_fecha_entrega: $request->validated('d_fecha_entrega'),
            s_hora_registro: $request->validated('s_hora_registro'),
            s_personal_reg: $request->validated('s_personal_reg'),
            d_fecha_reg: $request->validated('d_fecha_reg'),
            i_estado: $request->validated('i_estado'),
    );
}

}