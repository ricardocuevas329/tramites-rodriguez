<?php

namespace App\Dtos\DetalleProcurador;
class UpdateDetalleProcuradorDto
{
    public function __construct(

        public readonly ?string $s_date_fin,
    )
    {
    }

    public function toArray()
    {
        return [
            's_date_fin' => $this->s_date_fin,
        ];
    }



}
