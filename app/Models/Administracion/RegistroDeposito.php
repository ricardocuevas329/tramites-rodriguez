<?php

namespace App\Models\Administracion;


use App\Models\Protocolar\Kardex;
use App\Models\User;
use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Deposito
 *
 * @property string $s_codigo
 * @property string $s_kardex
 * @property string $s_asesor
 * @property string|null $s_tipo
 * @property string|null $s_banco
 * @property Carbon|null $d_fecha_ope
 * @property string|null $s_num_ope
 * @property float|null $i_monto
 * @property Carbon|null $d_fecha_reg
 * @property Carbon|null $d_fecha_aprob
 * @property string|null $s_aprobado
 * @property int $i_estado
 * @property float|null $i_excedente
 * @property string|null $s_comentario
 *
 * @package App\Models\Administracion
 */
class RegistroDeposito extends Model
{
    use GenerateCode;

    protected $table = 'depositos';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false;
    protected $appends = ['kardex'];

    protected $casts = [
        'd_fecha_ope' => 'datetime: d/m/Y',
        'i_monto' => 'float',
        'd_fecha_reg' => 'datetime: d/m/Y',
        'd_fecha_aprob' => 'datetime: d/m/Y h:i',
        'i_estado' => 'int',
        'i_excedente' => 'float'
    ];


    protected $fillable = [
        's_kardex',
        's_asesor',
        's_tipo',
        's_banco',
        'd_fecha_ope',
        's_num_ope',
        'i_monto',
        'd_fecha_reg',
        'd_fecha_aprob',
        's_aprobado',
        'i_estado',
        'i_excedente',
        's_comentario',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($register) {
            $cod = (new RegistroDeposito())->generateCode((new RegistroDeposito())->table, 's_codigo', 12, 'DT');
            $register->s_codigo = $cod;
            $register->s_asesor = Auth::user()->nombre_compuesto;
            $register->i_estado = 1;
            $register->d_fecha_reg = date("Y-m-d H:i:s");

        });


    }

    public function scopeActive(Builder $query)
    {
        return $query->where('i_estado', 1);
    }

    public function scopeFiltros($query, $search)
    {
        if ($search) {
            return $query->where('s_kardex', 'LIKE', '%' . $search . '%')
                ->OrWhere('s_asesor', 'LIKE', '%' . $search . '%')
                ->OrWhere('s_tipo', 'LIKE', '%' . $search . '%')
                ->OrWhere('s_banco', 'LIKE', '%' . $search . '%')
                ->OrWhere('s_num_ope', 'LIKE', '%' . $search . '%')
                ->OrWhere('i_monto', 'LIKE', '%' . $search . '%')
                ->orWhereHas('aprobado', function ($qr) use ($search) {
                    return $qr->NombreCompuesto($search);
                });
        }
    }


    public function aprobado(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_aprobado');
    }

    public function fotos(): HasMany
    {
        return $this->HasMany(DepositosDetalle::class, 's_deposito', 's_codigo')
            ->active()
            ->where('file', '!=' , '')
            ->select('s_codigo', 's_deposito', 's_ruta', 'file','name','type','size');
    }


    public function getKardexAttribute(): Kardex|null
    {

        $tipo = preg_replace('/[0-9]/', '', $this->s_kardex);
        $numero = preg_replace('/[A-Za-z]/', '', $this->s_kardex);
        $kardex_format = str_pad($numero, 10, "0", STR_PAD_LEFT);
        return Kardex::where('s_tipokardex', $tipo)->where('s_kardex', $kardex_format)->select('s_kardex', 's_tipokardex', 's_codigo')->first();
    }


}
