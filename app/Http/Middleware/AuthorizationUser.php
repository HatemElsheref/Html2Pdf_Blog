<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Dashboard\NotificationTrait;
use Closure;

class AuthorizationUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {

        if (auth()->user()->hasPermission($permission))
            return $next($request);
        else
        toast('غير مسموح للك بالوصول','error')->position('top-start');
        return redirect(route('dashboard'));
    }
}
