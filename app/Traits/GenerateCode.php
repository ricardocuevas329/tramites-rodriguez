<?php
namespace App\Traits;

use Haruncpi\LaravelIdGenerator\IdGenerator;

/*
|--------------------------------------------------------------------------
| GenerateCode Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait GenerateCode
{
	/**
     * Return a success JSON response.
     *
     * @param  string  $table
     * @param  string  $field
     * @param  int|null  $length
     * @param  string  $prefix
     * @return \Illuminate\Http\JsonResponse
     */

	protected function generateCode(string $table , string $field, int $length, $prefix)
	{
		return IdGenerator::generate(['table' => $table, 'field' =>  $field, 'length' => $length, 'prefix' => $prefix ]);
	}



}
