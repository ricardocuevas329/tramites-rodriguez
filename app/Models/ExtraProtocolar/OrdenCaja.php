<?php

namespace App\Models\Extraprotocolar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCaja extends Model
{
    use HasFactory;
    protected $table = 'ordencaja';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		's_codigo',
        's_referencia',
        'd_fecha',
        's_hora',
        'i_situacion',
        'd_fecha_firma',
        'd_fecha_entrega',
        's_certifica',
        'i_estado',
	];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ordencaja) {
            $ordencaja->i_estado = 0;
            $ordencaja->i_situacion = "266";
            $ordencaja->d_fecha = date("Y-m-d");
            $ordencaja->s_hora = date("H:i:s");
        });
    }
}
