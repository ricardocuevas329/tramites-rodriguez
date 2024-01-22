<?php

namespace App\Models\Extraprotocolar;

use App\Models\Entidad\Empresa;
use App\Models\Entidad\Notario;
use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class CopiasCertificada
 *
 * @property string $s_codigo
 * @property int|null $i_copias
 * @property int|null $i_inicial
 * @property string|null $s_descripcion
 * @property string|null $s_pertenece
 * @property string|null $s_libros
 * @property string|null $s_consta
 * @property string|null $s_folios
 * @property string|null $s_cargo
 * @property string|null $s_legalizado
 * @property Carbon|null $d_fechaLegalizado
 * @property string|null $s_numeroReg
 * @property Carbon|null $d_fecha
 * @property string|null $s_hora
 * @property string|null $s_observacion
 * @property string|null $s_atendido
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar;
 */
class CopiaCertificada extends Model
{
    use GenerateCode;
    protected $table = 'copias_certificada';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'i_copias' => 'int',
        'i_inicial' => 'int',
        'd_fecha' => 'datetime: d/m/Y',
        'i_estado' => 'int',
        'd_fechaLegalizado' => 'date'
    ];

    protected $fillable = [
        'i_copias',
        'i_inicial',
        's_descripcion',
        's_pertenece', // relacion empresa
        's_libros',
        's_consta',
        's_folios',
        's_cargo',
        's_legalizado', // relacion notario
        'd_fechaLegalizado',
        's_numeroReg',
        'd_fecha',
        's_hora',
        's_observacion',
        's_atendido', // relacion personal
        'i_estado'
    ];


    protected $appends = ['fecha_legalizado'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($copia) {
            $cod = (new CopiaCertificada())->generateCode((new CopiaCertificada())->table, 's_codigo', 12, 'CC');
            $copia->s_codigo = $cod;
            $copia->i_estado = 1;
            $copia->d_fecha = date("Y-m-d");
            $copia->s_hora = date("H:i:s");
            $copia->s_atendido = Auth::user()?->s_codigo;
        });
    }

    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->where(function ($qr) use ($search) {
                $qr->where('s_descripcion', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_libros', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_consta', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_folios', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_cargo', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_numeroReg', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_observacion', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('empresa', function($qr) use ($search){
                        return $qr->where('s_nombre', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('personal', function($qr) use ($search){
                        return $qr->NombreCompuesto($search);
                    })->orWhereHas('legalizado', function($qr) use ($search){
                        return $qr->NombreCompuesto($search);
                    });
            });
        }
    }

    protected function fechaLegalizado(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->d_fechaLegalizado->format('Y-m-d')
        );
    }

    public function empresa(): HasOne
    {
        return $this->HasOne(Empresa::class,'s_codigo','s_pertenece');
    }

    public function personal(): HasOne
    {
        return $this->HasOne(User::class,'s_codigo','s_atendido');
    }

    public function legalizado(): HasOne
    {
        return $this->HasOne(Notario::class,'s_codigo','s_legalizado');
    }



}
