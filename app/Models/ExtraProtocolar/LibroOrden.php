<?php

namespace App\Models\ExtraProtocolar;

use App\Enums\ParticipantItems;
use App\Models\User;
use App\Traits\PermissionTravelUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;


/**
 * Class LibroOrden
 *
 * @property string $s_codigo
 *
 * @package App\Models\ExtraProtocolar\Extraprotocolar
 */
class LibroOrden extends Model
{


    protected $table = 'libro_orden';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    protected  $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        's_codigo'
    ];

}
