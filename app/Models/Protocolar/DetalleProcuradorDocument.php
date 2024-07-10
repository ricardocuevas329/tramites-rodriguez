<?php


namespace App\Models\Protocolar;

use App\Models\User;
use App\Traits\GenerateCode;
use App\Traits\UploadFileStorage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class DetalleProcuradorDocument
 *
 * @property int $id
 * @property int|null $id_detalle_procurador
 * @property string|null $file
 * @property string|null $name
 * @property string|null $type
 * @property string|null $size
 * @property int|null $i_estado
 * @property string|null $tipo_doc
 *
 *
 * @package App\Models
 */
class DetalleProcuradorDocument extends Model
{
    use GenerateCode, UploadFileStorage;

    protected $table = 'detalle_procurador_documentos';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'i_estado' => 'boolean'
    ];

    protected $fillable = [
        'id_detalle_procurador',
        'file',
        'name',
        'type',
        'size',
        'i_estado',
        'tipo_doc'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $payload->i_estado = 1;
            $payload->s_personal = Auth::user()->s_codigo;
        });

    }


    public function file(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->generateURLSignatureTemp($value);
            }
        );
    }
    public function name(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                $maxLength = 100;
                if (strlen($value) > $maxLength) {
                    $extensionIndex = strrpos($value, '.');
                    if ($extensionIndex !== false && $extensionIndex >= ($maxLength - 4)) {
                        return substr($value, 0, $extensionIndex);
                    } else {
                        return substr($value, 0, $maxLength);
                    }
                } else {
                    return $value;
                }
            }
        );

    }

    public function personal(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_personal');
    }


}
