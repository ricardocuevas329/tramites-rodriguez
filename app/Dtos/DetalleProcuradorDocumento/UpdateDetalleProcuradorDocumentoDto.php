<?php

namespace App\Dtos\DetalleProcuradorDocumento;

use App\Http\Requests\Protocolar\Procurador\Document\UpdateProcuradorDocument;

class UpdateDetalleProcuradorDocumentoDto
{
    public function __construct(
        public readonly ?string $file,
        public readonly ?string $name,
        public readonly ?int    $size,
        public readonly ?string $type,

    )
    {
    }

    public function toArray()
    {
        return [
            'file' => $this->file,
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->type,
        ];
    }

    public static function fromApiRequest(UpdateProcuradorDocument $request): UpdateDetalleProcuradorDocumentoDto
    {
        return new self(
            file: $request->validated('file'),
            name: $request->validated('name'),
            size: $request->validated('size'),
            type: $request->validated('type'),
        );
    }

}
