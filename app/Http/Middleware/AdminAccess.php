<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
  /**
   * Handle an incoming request.
   *
   * @param  Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
      if (Auth::guard($guard)->check()) {
        if(Auth::user()->role == User::ROLE_SUPERADMIN){
          return $next($request);
        }else{
          Auth::logout();
          return redirect('login');
        }
      }

      return redirect('login');
  }
}
