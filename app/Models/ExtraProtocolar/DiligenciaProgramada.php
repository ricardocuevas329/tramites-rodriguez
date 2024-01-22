<?php

namespace App\Models\ExtraProtocolar;

use App\Models\Extraprotocolar\Carta;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class DiligenciaProgramada extends Model
{
    use HasFactory;
    protected $table = 'diligencia_programada';
    protected $primaryKey = 'i_codigo';

	protected $casts = [
		'estado' => 'int',
        'created_at' => 'datetime: d/m/Y',
	];

	protected $fillable = [
        'i_codigo',
		'd_fecha_programacion',
		's_num_carta',
		's_observacion',
        's_motorizado',
        's_personal_reg',
        'estado'
	];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($diligencia_programada) {
            $diligencia_programada->i_estado = 1;
            $diligencia_programada->s_personal_reg = Auth::user()->s_codigo;
        });
    }

    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->Where('i_codigo', 'LIKE', '%' . $search . '%')
                ->orWhere('d_fecha_programacion', 'LIKE', '%' . $search . '%')
                ->orWhere('s_num_carta', 'LIKE', '%' . $search . '%')
                ->orWhere('s_observacion', 'LIKE', '%' . $search . '%')
                ->orWhere('s_motorizado', 'LIKE', '%' . $search . '%');
        }
    }


    public function cartas(): HasMany
    {
        return $this->hasMany(Carta::class,'s_numcarta','s_num_carta');
    }

    public function diligencia_carta(): HasOne
    {
        return $this->hasOne(DiligenciaCarta::class, 's_num_carta', 's_num_carta');
    }

    public function motorizado(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_motorizado');
    }
}
