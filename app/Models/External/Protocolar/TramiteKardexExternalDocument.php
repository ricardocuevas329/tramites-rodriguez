<?php

namespace App\Models\External\Protocolar;

use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TramiteKardexExternalDocument extends Model
{
    use HasFactory, SoftDeletes, UploadFileStorage;



    protected $table = 'tramite_kardex_externo_document';
    protected $appends = ['options', 'source', 'filepond'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];
    protected $fillable = [
        'id_kardex',
        'file',
        'name',
        'size',
        'type',
        'tipo_archivo',
        'personal',
        'cod_personal'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $payload->personal = Auth::user()?->nombre_compuesto;
            $payload->cod_personal = Auth::user()?->s_codigo;
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
                'id_kardex' => $this->id_kardex
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


    public function cliente_external(): BelongsTo
    {
        return $this->belongsTo(ClientExternal::class,'id_kardex');
    }
}
