<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GainController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_gain')) {
            abort(403);
        }

        $users = User::get();

        return view('admin.pages.dashboards.gains.index', compact('users'));
    }
}
