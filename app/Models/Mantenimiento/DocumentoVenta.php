<?php
namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentoVenta
 *
 * @property string $s_codigo
 * @property string|null $s_nombre
 * @property string|null $s_abrev
 * @property string|null $s_serie
 * @property string|null $s_impresora
 * @property int|null $i_tipoComprobanteFe
 * @property int|null $i_estado
 *
 * @package App\Models
 */
class DocumentoVenta extends Model
{
	protected $table = 'documentos_caja';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;
	protected $appends = [
		'id_tipo_comprobante'
	];
	protected $casts = [
		'i_tipoComprobanteFe' => 'int',
		'i_estado' => 'int',
		'idTipoComprobante' => 'int'
	];

	protected $fillable = [
        's_codigo',
		's_nombre',
		's_abrev',
		's_serie',
		's_impresora',
		'i_tipoComprobanteFe',
		'i_estado'
	];

	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%')
                ->orWhere('s_abrev', 'LIKE', '%' . $value . '%')
				->orWhere('s_serie', 'LIKE', '%' . $value . '%')
				->orWhere('s_impresora', 'LIKE', '%' . $value . '%');
        }
    }

	protected function idTipoComprobante(): Attribute
    {
        return Attribute::make(
			get: fn () => $this->i_tipoComprobanteFe,
        );
    }



}
