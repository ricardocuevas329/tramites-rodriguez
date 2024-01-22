<?php

namespace App\Dtos\Role;

use App\Http\Requests\Mantenimiento\Role\StoreRoleRequest;
use App\Http\Requests\Mantenimiento\Role\UpdateRoleRequest;

class RoleDto
{
    public function __construct(
 
      public readonly ?string $name,
 
    ){}
        
        public static function fromApiRequest(StoreRoleRequest|UpdateRoleRequest  $request): RoleDto
        {
            return new self(
           
            name: $request->validated('name'),
          
    );
}

}