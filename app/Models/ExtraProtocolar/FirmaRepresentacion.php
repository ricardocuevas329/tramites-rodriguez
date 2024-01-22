<?php

namespace App\Models\ExtraProtocolar;


use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Firma
 *
 * @property string|null $s_codigo
 * @property string|null $s_representacion
 * @property string|null $s_cliente
 * @property Carbon|null $s_observacion
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class FirmaRepresentacion extends Model
{
    use GenerateCode;

    protected $table = 'firmarepresentacion';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false;
    protected $casts = [
        'd_fechaRegistro' => 'datetime:Y-m-d',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_codigo',
        's_representado',
        's_cliente',
        's_observacion',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($firma) {
            $cod = (new FirmaRepresentacion())->generateCode((new FirmaRepresentacion())->table, 's_codigo', 12, 'FR');
            $firma->s_codigo = $cod;
            $firma->i_estado = 1;
        });

    }

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }


    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_observacion', 'LIKE', '%' . $value . '%');
        }
    }


    public function cliente(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_cliente');
    }

}
