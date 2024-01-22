<?php

namespace App\Dtos\LibroOrden;
class LibroOrdenDto
{
    public function __construct(
       public readonly ?string $s_codigo,
    ){}public function toArray()
        {
  return [ 
            's_codigo' =>$this->s_codigo,
];  
 } 
  
        public static function fromApiRequest(StoreLibroOrdenRequest|UpdateLibroOrdenRequest  $request): LibroOrdenDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
    );
}

}