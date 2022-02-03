<?php

namespace App\Http\Controllers\Admin\Pages;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Game;
use App\Models\Bet;

class HomeController extends Controller
{
    public function index()
    {
        // $user= auth()->user();
        //$user->assignRole('Administrador');
        //$user= auth()->user()->hasAllRoles(Role::all());

        $User = Auth::user();
        $FiltroUser = client::where('name', $User['name'])->first();
        $this->FiltroUser = $FiltroUser;
        
        $JogosFeitos = game::where('user_id', $User['id'])->count();
        $saldo =(double) auth()->user()->balance;

        // mandando valores para dashboar
        return view('admin.pages.home', compact('User', 'FiltroUser', 'JogosFeitos', 'saldo'));
    }

    public function riot(Request $request)
    {
        dd($request->all());
    }
}
