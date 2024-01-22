<?php

namespace App\Dtos\PermisoViajeExternal;

use App\Http\Requests\External\PermisoViajeExternal\StorePermisoViajeExternalRequest;

class PermisoViajeExternalDto
{
    public function __construct(
        public readonly ?string $date_ret,
        public readonly ?string $date_sal,
        public readonly ?string $id_user_read,
        public readonly ?string $line,
        public readonly ?string $obervation,
        public readonly ?string $route,
        public readonly ?int    $transport,
        public readonly ?string $travel,
        public readonly ?int    $type,
        public readonly ?array  $participantes,
        public readonly ?array  $files,
        public readonly ?string $phone,
        public readonly ?string $email,
    )
    {
    }

    public function toArray(): array
    {
        return [

            'date_ret' => $this->date_ret,
            'date_sal' => $this->date_sal,
            'id_user_read' => $this->id_user_read,
            'line' => $this->line,
            'obervation' => $this->obervation,
            'route' => $this->route,
            'transport' => $this->transport,
            'travel' => $this->travel,
            'type' => $this->type,
            'participantes' => $this->participantes,
            'files' => $this->files,
            'phone' => $this->phone,
            'email' => $this->email,
            'return' => 0
        ];
    }

    public static function fromApiRequest(StorePermisoViajeExternalRequest $request): PermisoViajeExternalDto
    {
        return new self(
            date_ret: $request->validated('date_ret'),
            date_sal: $request->validated('date_sal'),
            id_user_read: $request->validated('id_user_read'),
            line: $request->validated('line'),
            obervation: $request->validated('obervation'),
            route: $request->validated('route'),
            transport: $request->validated('transport'),
            travel: $request->validated('travel'),
            type: $request->validated('type'),
            participantes: $request->validated('participantes'),
            files: $request->validated('files'),
            phone: $request->validated('phone'),
            email: $request->validated('email'),
        );
    }

}
