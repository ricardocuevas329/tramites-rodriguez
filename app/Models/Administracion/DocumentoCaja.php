<?php
 
namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentosCaja
 * 
 * @property string $s_codigo
 * @property string|null $s_nombre
 * @property string|null $s_abrev
 * @property string|null $s_serie
 * @property string|null $s_impresora
 * @property int|null $i_tipoComprobanteFe
 * @property int|null $i_estado
 *
 * @package App\Models\Administracion
 */
class DocumentoCaja extends Model
{
	protected $table = 'documentos_caja';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_tipoComprobanteFe' => 'int',
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_nombre',
		's_abrev',
		's_serie',
		's_impresora',
		'i_tipoComprobanteFe',
		'i_estado'
	];
}
