<?php

namespace App\Models\Protocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class HistorialTramite
 *
 * @property string|null $s_tramite
 * @property int|null $i_tipo
 * @property string|null $s_personal
 * @property string|null $s_observacion
 *
 * @package App\Models\Interviniente
 */
class HistorialTramite extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'historial_tramite';
    protected $casts = [
         'created_at' => 'datetime:d/m/Y H:i a'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($client) {
            $client->i_tipo = 0;
            $client->s_personal = Auth::user()?->s_codigo;
        });
    }

    public function personal(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_personal');
    }

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_personal');
    }


    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_personal');
    }
}
