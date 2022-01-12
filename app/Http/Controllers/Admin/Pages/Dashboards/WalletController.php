<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        return view('admin.pages.dashboards.wallet.index');
    }
}
