<?php

namespace App\Http\Controllers\Admin\Pages;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
                $user= auth()->user();
        //$user->assignRole('Administrador');
        //$user= auth()->user()->hasAllRoles(Role::all());
        return view('admin.pages.home');
    }

    public function riot(Request $request)
    {
        dd($request->all());
    }
}
