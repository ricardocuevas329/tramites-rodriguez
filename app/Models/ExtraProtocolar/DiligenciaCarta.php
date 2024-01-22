<?php

namespace App\Models\ExtraProtocolar;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class DiligenciaCarta extends Model
{
    use HasFactory;
    protected $table = 'diligencia_carta';
    protected $primaryKey = 'i_codigo';

    protected $casts = [
        'i_estado' => 'int',
        'd_fecha_entrega' => 'datetime: d/m/Y h:s',
    ];

    protected $fillable = [
        'i_codigo',
        's_num_carta',
        'd_fecha_entrega',
        's_recibido_por',
        's_recibido_dni',
        's_relacion_destinatario',
        's_pisos',
        's_color',
        's_puertas',
        's_ventanas',
        's_proyeccion',
        's_observacion',
        's_diligenciado',
        'i_estado',
        'inmueble'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($diligencia_carta) {
            $diligencia_carta->i_estado = 1;
            $diligencia_carta->d_fecha_entrega = date("Y-m-d H:i:s");
            $diligencia_carta->s_diligenciado = Auth::user()->s_codigo;
        });
    }

    public function fotos(): HasMany
    {
        return $this->HasMany(DiligenciaFoto::class, 'i_diligencia_carta', 'i_codigo');
    }

    public function personal(): HasOne
    {
        return $this->HasOne(User::class, 's_codigo', 's_diligenciado');
    }


}
