<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_sale')) {
            abort(403);
        }

        $users = User::get();


        return view('admin.pages.dashboards.sales.index', compact('users'));
    }
}
