<?php

namespace App\Models\ExtraProtocolar;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LibroDocument
 *
 * @property int $id
 * @property int $id_firma
 * @property string $text
 * @property array $options
 * @property string $file
 * @property string $name
 * @property int $size
 * @property string $type
 * @package App\Models\ExtraProtocolar\Extraprotocolar
 */
class FirmaDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "firma_document";
    protected $fillable = [
        'id_firma',
        'file',
        'name',
        'size',
        'type',
    ];
    protected $appends = ['options', 'source', 'filepond'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];

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


    protected function serverId(): Attribute
    {
        return Attribute::make(
            get: fn(): int => $this->id,
        );
    }

    public function filepond(): Attribute
    {
        return Attribute::make(
            get: fn($value): array => [
                'id' => $this->id,
                'name' => $this->name,
                'size' => $this->size,
                'type' => $this->type,
                'base64' => $this->file,
                'file' => $this->file,
                'id_libro' => $this->id_libro
            ]
        );

    }


    public function options(): Attribute
    {
        return Attribute::make(
            get: fn($value): array => [
                'type' => 'local',
                'metadata' => [
                    'date' => $this->created_at
                ],
                'file' => [
                    'file' => $this->file,
                    'id_primary' => $this->id,
                    'name' => $this->name,
                    'size' => $this->size,
                    'type' => $this->type,
                ],
            ]
        );
    }

    public function source(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $this->file
        );

    }

}
