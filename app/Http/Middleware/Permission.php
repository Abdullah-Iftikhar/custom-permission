<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $name)
    {
        $permission = Route::getCurrentRoute()->getActionMethod();
        if(auth()->user()->hasPermissionTo(trim($name), trim($permission))) {
            return $next($request);
        }
        return redirect()->back()->with('error', "You don't have right access.");
    }
}
