<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function commissionIndex()
    {
        if(!auth()->user()->hasPermissionTo('read_payments_commission')){
            abort(403);
        }

        return view('admin.pages.bets.payment.commission.index');
    }

    public function drawIndex()
    {
        if(!auth()->user()->hasPermissionTo('read_payments_draw')){
            abort(403);
        }

        return view('admin.pages.bets.payment.draw.index');
    }
}
