<?php


namespace App\Models\Protocolar;

use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class DetallePresencia
 *
 * @property string $s_codigo
 * @property string|null $s_referencia
 * @property string|null $s_actonotarial
 * @property string|null $s_descripcion
 * @property string|null $s_hora_inicio
 * @property string|null $s_hora_fin
 * @property Carbon|null $d_fechapresen
 * @property string|null $s_lugar
 * @property string|null $s_asitente
 * @property string|null $s_observacion
 * @property int|null $i_cantidad
 * @property float|null $de_precio
 * @property int|null $i_estado
 *
 * @package App\Models
 */
class DetallePresencia extends Model
{
    use GenerateCode;
    protected $table = 'detalle_presencias';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'd_fechapresen' => 'datetime:d/m/Y',
        'i_cantidad' => 'int',
        'de_precio' => 'float',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_referencia',
        's_actonotarial',
        's_descripcion',
        's_hora_inicio',
        's_hora_fin',
        'd_fechapresen',
        's_lugar',
        's_asitente',
        's_observacion',
        'i_cantidad',
        'de_precio',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $cod = (new DetallePresencia())->generateCode((new DetallePresencia())->table, 's_codigo', 12, 'DP');
            $payload->s_codigo = $cod;
            $payload->i_estado = 1;
            $payload->d_fechapresen = date('Y-m-d');
            //$payload->s_asitente = Auth::user()->s_codigo;
        });

    }

    public function asistente(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_asitente');
    }

}
