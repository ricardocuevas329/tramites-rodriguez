<?php


namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DepositosDetalle
 *
 * @property int $s_codigo
 * @property string $s_deposito
 * @property string $s_ruta
 * @property string $s_img
 * @property int $i_estado
 * @property string $file
 * @property string $name
 * @property int $size
 * @property string $type
 *
 * @package App\Models\ExtraProtocolar
 */
class DepositosDetalle extends Model
{
    protected $table = 'depositos_detalle';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    protected $appends = ['options', 'source', 'filepond'];
    protected $casts = [
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_deposito',
        's_ruta',
        's_img',
        'i_estado',
        'file',
        'name',
        'size',
        'type',
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('i_estado', 1);
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

    public function filepond(): Attribute
    {
        return Attribute::make(
            get: fn($value): array => [
                'id' => $this->s_codigo,
                'name' => $this->name,
                'size' => $this->size,
                'type' => $this->type,
                'base64' => $this->file,
                'file' => $this->file,
                's_deposito' => $this->s_deposito
            ]
        );

    }


    public function options(): Attribute
    {
        return Attribute::make(
            get: fn($value): array => [
                'type' => 'local',
                'file' => [
                    'file' => $this->file,
                    'id_primary' => $this->s_codigo,
                    'name' => $this->name,
                    'size' => $this->size,
                    'type' => $this->type,
                    'id_reference_relation' => $this->s_deposito
                ],
            ]
        );
    }

    public function source(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|null => $this->file
        );

    }

}
