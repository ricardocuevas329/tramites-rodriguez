<?php

namespace App\Traits;

use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait MiddlewarePermission
{
   /**
    * Return a success JSON response.
    *
    * @param  array  $permissions
    * @param  string  $search_permission
    * @return \Illuminate\Http\JsonResponse
    */


   public function verifyPermission(array $permissions, string $search_permission)
   {

      if (auth()->user()->hasRole('superadmin')) {
         return true;
      }

      if (count(Arr::where($permissions, fn ($value, $key) => $value  === $search_permission))) {
         return true;
      }

      abort(403, "No Access!");
   }
}
