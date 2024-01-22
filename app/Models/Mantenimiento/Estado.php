<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'estado';
    protected $primaryKey = 'i_codigo';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        's_codigo_sbs', 's_tipo', 's_desc', 'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($estado) {
            $estado->i_codigo = self::getNextICodigo();
        });

    }

        public static function getNextICodigo()
    {
        $maxICodigo = DB::table((new Estado())->table)->max('i_codigo');
        return $maxICodigo + 1;
    }

    protected function sDesc(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value) => strtoupper($value),
        );
    }


    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_codigo_sbs', 'LIKE', '%' . $value . '%')
				->orWhere('s_tipo', 'LIKE', '%' . $value . '%');
            }
    }

    public function scopeActivosRef($query)
    {
      return $query->where('i_estado', 1)->where('s_tipo', 24);
    }

    public function scopeActivosCon($query)
    {
      return $query->where('i_estado', 1)->where('s_tipo', 19);
    }

}
