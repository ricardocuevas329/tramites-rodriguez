<?php

namespace App\Models\Extraprotocolar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaOrden extends Model
{
    use HasFactory;
    protected $table = 'carta_orden';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
	public $timestamps = false;


	protected $fillable = [
		's_codigo',
	];
}
