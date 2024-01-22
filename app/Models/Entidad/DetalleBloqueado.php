<?php

namespace App\Models\Entidad;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleBloqueado extends Model
{
    use HasFactory, GenerateCode;

    protected $table = 'detalle_bloqueados';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

    /*protected $dates = [
		'i_estado' 
	];

    const DELETED_AT = 'i_estado';*/


	protected $fillable = [
		's_codigo',
		's_codreg_bloq',
		's_compareciente',
        's_nombres',
        's_paterno',
        's_materno',
		'i_estado'
	];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($detallebloqueado) {
            $cod = (new DetalleBloqueado())->generateCode((new DetalleBloqueado())->table, 's_codigo', 12, 'DB');
            $detallebloqueado->s_codigo = $cod;
            $detallebloqueado->s_codreg_bloq = $detallebloqueado->s_codreg_bloq;
            $detallebloqueado->i_estado = 1;
        });
        static::deleting(function($detallebloqueado){
            // save custom delete value
            $detallebloqueado->i_estado = 0;
            $detallebloqueado->save();
        });
    }

    public static function bootWithParameter($param)
    {
        static::creating(function ($detallebloqueado) use ($param) {
            $detallebloqueado->s_codreg_bloq = $param;
        });
    }


    public function delete()
    {
            $this->update(['i_estado' => 0 ]);
            return true;
    }

}
