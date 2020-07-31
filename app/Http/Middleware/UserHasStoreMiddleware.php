<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
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
        $store = (auth()->user()->store);

        if ($store) {
            flash("Você já possui a loja \"$store->name\"!")->warning();
            return redirect()->route('admin.stores.index');
        }

        return $next($request);
    }
}
