<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancoDeposito extends Model
{
    use HasFactory;
    protected $table = 'banco_deposito';
    protected $primaryKey = 'i_codigo';
    public $timestamps = false;
    protected $fillable = [
        's_nombre', 's_contable', 's_descripcion',  's_tipo', 'i_estado'
    ];

    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%')
                ->orWhere('s_contable', 'LIKE', '%' . $value . '%')
				->orWhere('s_descripcion', 'LIKE', '%' . $value . '%')
				->orWhere('s_tipo', 'LIKE', '%' . $value . '%');
        }
    }
}
