<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class resetPasswordDefault
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $blockAccess = false;
       
        if(Hash::check('123456', auth()->user()->s_pass)) $blockAccess = true;
          if($blockAccess){
              abort(403, 'actualiza tu clave');
          }
       
        return $next($request);
    }
}
