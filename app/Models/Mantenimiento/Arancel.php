<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arancel extends Model
{
    use HasFactory;
    protected $table = 'arancel';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    public function scopeServicio($query, $value)
    {
        if ($value) {
            return $query->where('s_servicio', $value);
        }
    }

}
