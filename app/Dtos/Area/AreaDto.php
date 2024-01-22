<?php

namespace App\Dtos\Area;

use App\Http\Requests\Administracion\Area\StoreAreaRequest;
use App\Http\Requests\Administracion\Area\UpdateAreaRequest;

class AreaDto
{
    public function __construct(

        public readonly ?string $s_nombre,
        public readonly ?string $s_descarea,

    ) {
    }

    public static function fromApiRequest(StoreAreaRequest|UpdateAreaRequest  $request): AreaDto
    {
        return new self(
            s_nombre: $request->validated('s_nombre'),
            s_descarea: $request->validated('s_descarea'),
        );
    }
}
