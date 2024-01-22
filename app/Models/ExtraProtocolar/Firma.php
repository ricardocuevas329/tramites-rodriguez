<?php

namespace App\Models\ExtraProtocolar;


use App\Models\Entidad\Cliente;
use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class Firma
 *
 * @property string|null $s_codigo
 * @property string|null $s_cliente
 * @property string|null $s_proceder
 * @property Carbon|null $d_fechaRegistro
 * @property string|null $s_atendido
 * @property string|null $foto_firma
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class Firma extends Model
{
    use GenerateCode;

    protected $table = 'firmas';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false;
    protected $casts = [
        'd_fechaRegistro' => 'datetime:Y-m-d',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_codigo',
        's_cliente',
        'd_fechaRegistro',
        's_proceder',
        'd_caducidad',
        's_atendido',
        'foto_firma',
        'i_estado',
    ];

    //protected $appends = ['participa_como'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($firma) {
            $cod = (new Firma())->generateCode((new Firma())->table, 's_codigo', 12, 'FI');
            $firma->s_codigo = $cod;
            $firma->i_estado = 1;
            $firma->d_fechaRegistro = date("Y-m-d H:i:s");
            $firma->s_atendido = Auth::user()->s_codigo;
        });

    }

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }


    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('d_caducidad', 'LIKE', '%' . $value . '%')
                ->orWhere('s_proceder', 'LIKE', '%' . $value . '%')
                ->orWhereHas('cliente', function ($qr) use ($value) {
                    return $qr->NombreCompuesto($value);
                })->orWhereHas('atendido', function ($qr) use ($value) {
                    return $qr->NombreCompuesto($value);
                });
        }
    }


    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_cliente')->with(['nacionalidad', 'ubigeo']);
    }

    public function atendido(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_atendido');
    }

    public function representacion(): HasMany
    {
        return $this->HasMany(FirmaRepresentacion::class, 's_representado', 's_codigo')
            ->with(['cliente' => function ($query) {
                $query->select('s_codigo', 's_nombre');
            }])
            ->active();
    }

    public function files(): HasMany
    {
        return $this->hasMany(FirmaDocument::class, 'id_firma', 's_codigo');
    }
}
