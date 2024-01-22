<?php

namespace App\Models\Protocolar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoKarde
 *
 * @property string $s_codigo
 * @property string|null $s_nombre
 * @property string|null $s_abre
 * @property string|null $s_descripcion
 * @property string|null $s_clase
 * @property int|null $i_estado
 *
 * @package App\Models\Protcolar
 */
class TipoKardex extends Model
{
    use HasFactory;
    protected $table = 'tipo_kardes';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_nombre',
        's_abre',
        's_descripcion',
        's_clase',
        'i_estado'
    ];

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }

}
