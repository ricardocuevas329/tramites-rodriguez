<?php

namespace App\Dtos\Permission;

use App\Http\Requests\Mantenimiento\Permission\StorePermissionRequest;
use App\Http\Requests\Mantenimiento\Permission\UpdatePermissionRequest;

class PermissionDto
{
    public function __construct(
      public readonly ?string $name,
    ){}
        
        public static function fromApiRequest(StorePermissionRequest|UpdatePermissionRequest  $request): PermissionDto
        {
            return new self(
            name: $request->validated('name')
    );
}

}