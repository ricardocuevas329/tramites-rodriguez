<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleRango
 *
 * @property string $s_codigo
 * @property string|null $s_servicios
 * @property string|null $s_colum1
 * @property string|null $s_colum2
 * @property float|null $de_precio
 *
 * @package App\Models\Administracion
 */
class DetalleRango extends Model
{
    use HasFactory;
    protected $table = 'detalle_rango';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'de_precio' => 'float'
    ];

    protected $fillable = [
        's_servicios',
        's_colum1',
        's_colum2',
        'de_precio'
    ];
}
