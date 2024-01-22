<?php
namespace App\Models\Mantenimiento;

use Spatie\Permission\Models\Permission as PermissionSpatie;

/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class Permission extends PermissionSpatie
{

    
    
	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('name', 'LIKE', '%' . $value . '%');
        }
    }
}
