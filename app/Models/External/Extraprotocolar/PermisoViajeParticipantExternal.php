<?php

namespace App\Models\External\Extraprotocolar;

use App\Models\ExtraProtocolar\PermisoViajeDocument;
use App\Traits\PermissionTravelUtils;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermisoViajeParticipantExternal extends Model
{
    use HasFactory, SoftDeletes, PermissionTravelUtils;
    protected $table = 'permiso_viaje_participant_external';
    protected $fillable = [
        'id_permiso_viaje' ,
        'type_doc' ,
        'num_doc' ,
        'name' ,
        'paternal' ,
        'maternal' ,
        'birthday' ,
        'age' ,
        'type' ,
        'sex' ,
        'status_civil' ,
        'nationality' ,
        'locality' ,
        'address' ,
        'with_signature' ,
        'email' ,
        'num_partida' ,
        'sede_registral' ,
    ];
    protected $appends = ['nombre_compuesto', 'rol'];


    protected function nombreCompuesto(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->name.' '.$this->paternal.' '.$this->maternal,
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function paternal(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function maternal(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function files(): HasMany
    {

        return $this->hasMany(PermisoViajeDocument::class,'id_participant','id')
            ->limit(15);
    }


    public function rol(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $this->getNameParticipatesAs($this->type)
        );

    }


}
