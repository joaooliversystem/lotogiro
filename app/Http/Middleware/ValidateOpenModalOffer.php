<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ValidateOpenModalOffer
{
    use LivewireAlert;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!isset($_COOKIE['offerNegative'])){
            setcookie('offerNegative', 'close', (time() + 1200));

            if(auth()->user()->balance <= 0){
                setcookie('offerNegative', 'open', (time() + 1200));
            }

            if(auth()->user()->balance > 0){
                setcookie('offerNegative', 'close', (time() + (3 * 24 * 3600)));
            }
        }

        return $next($request);
    }
}
