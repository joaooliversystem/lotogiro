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
    public function recharge()
    {
        return view('admin.pages.dashboards.wallet.index');
    }
    public function transfer()
    {
        return view('admin.pages.dashboards.wallet.transfer');
    }
    public function withdraw()
    {
        return view('admin.pages.dashboards.wallet.withdraw');
    }
    public function extract()
    {
        return view('admin.pages.dashboards.wallet.extract');
    }
}
