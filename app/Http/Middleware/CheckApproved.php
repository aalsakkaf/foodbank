<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckApproved
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
        //dd($request->user());
        if ($request->user()->status == "Pending" ) {
            return redirect()->route('waiting');
        } else if ($request->user()->status == "Blocked"){
            return redirect()->route('document.create');
        }

        return $next($request);
    }
}
