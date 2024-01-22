<?php

namespace App\Models\Entidad;

use App\Models\Mantenimiento\Estado;
use App\Models\User;
use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
//use Illuminate\Database\Eloquent\SoftDeletes;

class ComparecienteBloqueado extends Model
{
    use HasFactory, GenerateCode;
    protected $table = 'comparecientes_bloqueados';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;

	protected $casts = [
		'i_estado' => 'int',
        'created_at' => 'datetime:d/m/Y'
	];

	protected $fillable = [
		's_codigo',
		's_referencia',
		's_numero',
        's_condicion',
        's_observacion',
        's_ruta',
        's_personal',
		'i_estado'
	];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($detallebloqueado) {
            $cod = (new ComparecienteBloqueado())->generateCode((new ComparecienteBloqueado())->table, 's_codigo', 10, 'BL');
            $detallebloqueado->s_codigo = $cod;
            $detallebloqueado->i_estado = 1;
        });

        /*static::deleting(function($detallebloqueado)
        {
            // save custom delete value
            $detallebloqueado->i_estado = 0;
            $detallebloqueado->save();
        });
        */
    }
    public function referencia(): HasOne
    {
        return $this->hasOne(Estado::class, 'i_codigo', 's_referencia')
        ->select('s_desc','i_codigo');
    }

    public function condicion(): HasOne
    {
        return $this->hasOne(Estado::class, 'i_codigo', 's_condicion')
        ->select('s_desc','i_codigo');
    }

    public function personal(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_personal')
        ->select('s_nombres','s_nombre_seg','s_paterno','s_materno','s_codigo');
    }

    public function comparecientes(): HasMany
    {
        return $this->hasMany(DetalleBloqueado::class, 's_codreg_bloq', 's_codigo')->where('i_estado', 1);
    }

    public function deleteComparecientes()
    {
        if($this->comparecientes){
            $this->comparecientes()->update(['i_estado' => 0 ]);
            return true;
        }

    }

	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_referencia', 'LIKE', '%' . $value . '%')
                ->orWhere('s_condicion', 'LIKE', '%' . $value . '%');
        }
    }
}
