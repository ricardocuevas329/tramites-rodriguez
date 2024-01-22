<?php

namespace App\Dtos\Configuracion;

use App\Http\Requests\Administracion\Configuracion\StoreConfiguracionRequest;
use App\Http\Requests\Administracion\Configuracion\UpdateConfiguracionRequest;

class ConfiguracionDto
{
    public function __construct(
       public readonly ?Int $i_codigo,
      public readonly ?string $s_empresa,
      public readonly ?string $s_direccion,
      public readonly ?string $s_ruta_logo,
      public readonly ?string $s_ruta_fondo_login,
      public readonly ?string $d_fecha_registro,
      public readonly ?string $s_hora_registro,
      public readonly ?string $s_responsable,
      public readonly ?string $s_descripcion,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreConfiguracionRequest|UpdateConfiguracionRequest  $request): ConfiguracionDto
        {
            return new self(
            i_codigo: $request->validated('i_codigo'),
            s_empresa: $request->validated('s_empresa'),
            s_direccion: $request->validated('s_direccion'),
            s_ruta_logo: $request->validated('s_ruta_logo'),
            s_ruta_fondo_login: $request->validated('s_ruta_fondo_login'),
            d_fecha_registro: $request->validated('d_fecha_registro'),
            s_hora_registro: $request->validated('s_hora_registro'),
            s_responsable: $request->validated('s_responsable'),
            s_descripcion: $request->validated('s_descripcion'),
            i_estado: $request->validated('i_estado'),
    );
}

}