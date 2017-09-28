<?php

namespace App\Http\Middleware;

use Closure;

class AdminLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('admin') || session('admin')->user_name !='admin'){
            return redirect('admin/login');
        }

        return $next($request);
    }
}
