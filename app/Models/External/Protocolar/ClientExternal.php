<?php

namespace App\Models\External\Protocolar;

use App\Models\Protocolar\Kardex;
use App\Models\Protocolar\RegistroPublico;
use App\Models\Protocolar\ServicioNotarial;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientExternal extends Model
{
    use SoftDeletes;
    protected $table = 'clientes_tramites';
    protected $casts = [
        'created_at' => 'datetime:d/m/y h:i a',
    ];
    protected $appends = ['is_date_mayor', 'nombre_compuesto'];
    public $timestamps = false;
    protected $fillable = [
        'id',
        'documento',
        'materno',
        'nombres',
        'paterno',
        'tipo_documento',
        'kardex',
        'cod_personal',
        'cod_auth'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($client) {
            $client->created_at = now();
            $client->cod_personal = Auth::user()?->s_codigo;
        });
    }

    protected function getisDateMayorAttribute()
    {
      /*  $dateSignature = $this->detalle_kardex?->participantes_firmados?->where(function ($query) {
            return $query->whereDate('d_fechfirma', '>=', now());
        })->pluck('d_fechfirma');

        if ($dateSignature) {
            //$fechaFormateada = Carbon::parse($dateSignature)->format('d/m/Y');
            //return $fechaFormateada;
        }*/
    }

    public function nombreCompuesto(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->nombres . ' ' . $this->paterno . ' ' . $this->materno,
        );
    }

    protected function paterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function materno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function nombres(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->Where('documento', $value)
                ->NombreCompuesto($value)
                ->orWhere('kardex', $value)
                ->orWhereHas('detalle_kardex', function ($qr) use ($value) {
                    return $qr->Where('s_kardex', (int)$value);
                });
        }
    }

    public function scopeFilterByNumKardex($query, $value)
    {
        if ($value) {
            return $query->WhereHas('detalle_kardex', function ($qr) use ($value) {
                    return $qr->Where('s_kardex', (int) $value);
                });
        }
    }



    public function scopeNombreCompuesto($query, $search)
    {
        if ($search) {
            $query->orWhere(
                DB::raw(
                    "REPLACE(
                    CONCAT(
                        COALESCE(nombres,''),' ',
                        COALESCE(paterno,''),' ',
                        COALESCE(materno,'')
                    ),
                '  ',' ')"
                ),
                'like',
                '%' . $search . '%'
            );
        }
    }

    public function scopeMyRecords($query)
    {
        return $query->where('cod_personal', Auth::user()?->s_codigo);
    }

    public function detalle_kardex(): HasOne
    {
        return $this->HasOne(Kardex::class, 's_codigo', 'kardex');
    }

    public function servicio_notarial(): HasMany
    {
        return $this->HasMany(ServicioNotarial::class, 's_kardex', 'kardex')->notarial()->with('servicio');
    }

    public function servicio_registral(): HasMany
    {
        return $this->HasMany(ServicioNotarial::class, 's_kardex', 'kardex')->registral()->with('servicio');
    }

    public function files(): HasMany
    {
        return $this->HasMany(TramiteKardexExternalDocument::class, 'id_kardex', 'id')
            ->where('tipo_archivo', 'varios')->where('cod_personal', 'like', 'EP%')->orderBy('id', 'desc');
    }

    public function files_notaria(): HasMany
    {
        return $this->HasMany(TramiteKardexExternalDocument::class, 'id_kardex', 'id')
            ->where('tipo_archivo', 'varios')->where('cod_personal', 'like', 'PE%')->orderBy('id', 'desc');
    }

    public function files_testimonio(): HasMany
    {
        return $this->HasMany(TramiteKardexExternalDocument::class, 'id_kardex', 'id')
            ->where('tipo_archivo', 'testimonio')->orderBy('id', 'desc');
    }

    public function registro_publico(): HasMany
    {
        return $this->HasMany(RegistroPublico::class, 's_kardex', 'kardex');
    }
}
