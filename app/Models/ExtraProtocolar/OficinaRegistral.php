<?php

namespace App\Models\ExtraProtocolar;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OficinaRegistral
 *
 * @property string $s_codigo
 * @property string|null $s_codigo_sbs
 * @property string|null $s_nombre
 * @property int|null $i_estado
 *
 * @package App\Models\ExtraProtocolar
 */
class OficinaRegistral extends Model
{
	protected $table = 'oficina_registral';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_codigo_sbs',
		's_nombre',
		'i_estado'
	];
}
