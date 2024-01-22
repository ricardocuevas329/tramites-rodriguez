<?php

namespace App\Models\ExtraProtocolar;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property string $s_name
 * @property int $i_size
 * @property string $s_type
 *
 * @package App\Models\ExtraProtocolar
 */
class DiligenciaFoto extends Model
{
    use HasFactory;
    protected $table = 'diligencia_foto';
    protected $primaryKey = 'i_codigo';

	protected $fillable = [
		'i_codigo',
		'i_diligencia_carta',
		's_foto',
        's_name',
        's_type',
        'i_size',
	];

    public function SName(): Attribute
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

}
