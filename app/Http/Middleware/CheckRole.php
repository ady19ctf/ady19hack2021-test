<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($role == 'admin' && auth()->user()->typeid !=0){
            abort(403);
        }
//        if ($role == 'candidate' && auth()->user()->typeid !=1){
//            abort(403);
//        }
        if ($role == 'user' && auth()->user()->typeid !=2){
            abort(403);
        }
        return $next($request);
    }
}
