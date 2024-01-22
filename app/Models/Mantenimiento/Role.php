<?php

namespace App\Models\Mantenimiento;

use Spatie\Permission\Models\Role as RoleSpatie;
 
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class Role extends RoleSpatie
{
    
  
}
