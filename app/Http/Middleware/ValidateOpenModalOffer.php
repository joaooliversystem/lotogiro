<?php

namespace App\Http\Middleware;

use App\Models\LockModalOffer;
use Carbon\Carbon;
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
        $lockModal = LockModalOffer::where('user_id', auth()->id())->firstOr(function () {
            return LockModalOffer::create([
                'user_id' => auth()->id(),
                'status' => 0,
            ]);
        });

        if($this->expired($lockModal)) {
            if (auth()->user()->balance <= 0) {
                $lockModal->update([
                    'status' => 1
                ]);
                $lockModal->update([
                    'status' => 0
                ]);
            }

            if (auth()->user()->balance > 0) {
                $lockModal->update([
                    'status' => 0
                ]);
                $lockModal->update([
                    'status' => 1
                ]);
            }
        }
        auth()->user()->lockModal = $lockModal->status;

        return $next($request);
    }

    protected function expired($lockModal)
    {
        $time = Carbon::parse($lockModal->updated_at)->diffInMinutes(Carbon::now());

        return ($time >= 30);
    }
}
