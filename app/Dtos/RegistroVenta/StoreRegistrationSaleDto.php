<?php

namespace App\Dtos\RegistroVenta;

use App\Http\Requests\Administracion\RegistroVenta\StoreRegistroVentaRequest;
use App\Http\Requests\Administracion\RegistroVenta\UpdateRegistroVentaRequest;

class StoreRegistrationSaleDto
{
    public function __construct(

        public readonly ?array $detail_services,
        public readonly ?array $invoice,
        public readonly ?array $sales,

    ) {
    }

    public function toArray()
    {
        return [
            'detail_services' => $this->detail_services,
            'invoice' => $this->invoice,
            'sales' => $this->sales,
        ];
    }

    public static function fromApiRequest(StoreRegistroVentaRequest|UpdateRegistroVentaRequest $request): StoreRegistrationSaleDto
    {
        return new self(
            detail_services: $request->validated('detail_services'),
            invoice: $request->validated('invoice'),
            sales: $request->validated('sales'),

        );
    }
}
