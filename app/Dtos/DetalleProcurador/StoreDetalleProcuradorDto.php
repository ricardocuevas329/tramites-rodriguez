<?php

namespace App\Dtos\DetalleProcurador;
class StoreDetalleProcuradorDto
{
    public function __construct(


        public readonly ?string $s_date_inicio,
        public readonly ?string $s_presencia,


    )
    {
    }

    public function toArray()
    {
        return [
            's_date_inicio' => $this->s_date_inicio,
            's_presencia' => $this->s_presencia,
        ];
    }


}
