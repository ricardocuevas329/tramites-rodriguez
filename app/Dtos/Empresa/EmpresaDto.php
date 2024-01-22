<?php

namespace App\Dtos\Empresa;

use App\Http\Requests\Entidad\Empresa\StoreEmpresaRequest;
use App\Http\Requests\Entidad\Empresa\UpdateEmpresaRequest;

class EmpresaDto
{
    public function __construct(
     
      public readonly ?string $s_nombre,
      public readonly ?string $s_tip_doc,
      public readonly ?string $s_num_doc,
      public readonly ?Int $i_nacionalidad,
      public readonly ?string $s_localidad,
      public readonly ?string $s_direccion,
      public readonly ?string $s_referencia,
      public readonly ?string $s_email,
      public readonly ?string $s_web,
      public readonly ?string $s_telefono,
      public readonly ?string $s_celular,
      public readonly ?string $s_oficina,
      public readonly ?string $s_partida,
      public readonly ?string $s_registro,
      public readonly ?string $s_ciiu,
      public readonly ?string $s_objeto_social,
      public readonly ?string $s_anotacion,
  
    ){}
        
        public static function fromApiRequest(StoreEmpresaRequest|UpdateEmpresaRequest  $request): EmpresaDto
        {
            return new self(
         
            s_nombre: $request->validated('s_nombre'),
            s_tip_doc: $request->validated('s_tip_doc'),
            s_num_doc: $request->validated('s_num_doc'),
            i_nacionalidad: $request->validated('i_nacionalidad'),
            s_localidad: $request->validated('s_localidad'),
            s_direccion: $request->validated('s_direccion'),
            s_referencia: $request->validated('s_referencia'),
            s_email: $request->validated('s_email'),
            s_web: $request->validated('s_web'),
            s_telefono: $request->validated('s_telefono'),
            s_celular: $request->validated('s_celular'),
            s_oficina: $request->validated('s_oficina'),
            s_partida: $request->validated('s_partida'),
            s_registro: $request->validated('s_registro'),
            s_ciiu: $request->validated('s_ciiu'),
            s_objeto_social: $request->validated('s_objeto_social'),
            s_anotacion: $request->validated('s_anotacion'),
           
  
    );
}

}