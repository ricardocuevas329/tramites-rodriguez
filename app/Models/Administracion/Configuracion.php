<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
/**
 * Class SConfiguracion
 *
 * @property int $i_codigo
 * @property string|null $s_empresa
 * @property string|null $s_direccion
 * @property string|null $s_ruta_logo
 * @property string|null $s_ruta_fondo_login
 * @property Carbon|null $d_fecha_registro
 * @property string|null $s_hora_registro
 * @property string|null $s_responsable
 * @property string|null $s_descripcion
 * @property int|null $i_estado
 *
 * @package App\Models
 */
class Configuracion extends Model
{
    use HasFactory;
    protected $table = 's_configuracion';
	protected $primaryKey = 'i_codigo';
	public $timestamps = false;

	protected $casts = [
		'd_fecha_registro' => 'datetime',
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_empresa',
		's_direccion',
		's_ruta_logo',
		's_ruta_fondo_login',
		'd_fecha_registro',
		's_hora_registro',
		's_responsable',
		's_descripcion',
		'i_estado'
	];

    protected function sEmpresa(): Attribute
    {
        return Attribute::make(
			get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sResponsable(): Attribute
    {
        return Attribute::make(
			get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }


}
