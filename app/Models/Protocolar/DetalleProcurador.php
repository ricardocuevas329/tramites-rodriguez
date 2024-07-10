<?php


namespace App\Models\Protocolar;

use App\Enums\ProcuradorDocumentsTypes;
use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * Class DetalleProcurador
 *
 * @property int $id
 * @property string|null $s_presencia
 * @property string|null $s_procurador
 * @property Carbon|null $s_date_inicio
 * @property Carbon|null $s_date_fin
 * @property string|null $s_anotacion
 * @property int|null $i_estado
 *
 * @package App\Models
 */
class DetalleProcurador extends Model
{
    use GenerateCode;

    protected $table = 'detalle_procurador';
    protected $casts = [
        's_date_inicio' => 'datetime:d/m/Y H:i a',
        's_date_fin' => 'datetime:d/m/Y H:i a',
        'i_estado' => 'boolean'
    ];

    protected $fillable = [
        's_presencia',
        's_procurador',
        's_date_inicio',
        's_date_fin',
        's_anotacion',
        'i_estado',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $payload->i_estado = 1;
        });

    }

    public function documentos_init(): hasMany
    {
        return $this->hasMany(DetalleProcuradorDocument::class, 'id_detalle_procurador', 'id')
            ->where('tipo_doc', ProcuradorDocumentsTypes::INIT->value)->orderBy('id','desc');
    }
    public function documentos_finish(): hasMany
    {
        return $this->hasMany(DetalleProcuradorDocument::class, 'id_detalle_procurador', 'id')
            ->where('tipo_doc', ProcuradorDocumentsTypes::FINISH->value)->orderBy('id','desc');
    }


}
