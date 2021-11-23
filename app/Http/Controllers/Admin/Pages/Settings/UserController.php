<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Helper\Money;
use App\Http\Controllers\Controller;
use App\Models\TransactBalance;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('read_user')){
            abort(403);
        }

        if ($request->ajax()) {
            $user = $this->user->get()->where('id', '<>', auth()->user()->id);
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    $data = '';
                    if(auth()->user()->hasPermissionTo('update_user')){
                        $data .= '<a href="' . route('admin.settings.users.edit', ['user' => $user->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if(auth()->user()->hasPermissionTo('delete_user')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_user" user="' . $user->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_user"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->editColumn('name', function ($user) {
                    return $user->name. ' '. $user->last_name;
                })
                ->editColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.settings.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_user')){
            abort(403);
        }

        $roles = Role::orderBy('name')->get();

        return view('admin.pages.settings.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('create_user')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'email' => 'unique:App\Models\User|email:rfc|required|max:100',
            'password' => 'min:8|same:password_confirmation|required|max:15',
            'password_confirmation' => 'required|max:15',
            'commission' => 'required|integer|between:0,100',
        ]);
        $indicador = $request->indicador;
        if($indicador == null || $indicador == 0){
            $indicador = 1;
        }

        $auxRole;
        foreach ($request->roles as $role){
            $auxRole = $role;
        }

        try {
            $balanceRequest = 0;
            if($request->has('balance') && !is_null($request->balance)){
                $balanceRequest = Money::toDatabase($request->balance);
            }

            if($request->has('commission') && !is_null($request->commission)){
                $balanceRequest += Money::toDatabase(($request->commission/100) * $balanceRequest);
            }

            $user = new $this->user;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->commission = $request->commission;
            $user->indicador = $indicador;
            if($auxRole == 6){
                $user->type_client = 1;
            }
            $user->balance = $balanceRequest;
            $user->save();

            $this->storeTransact($user, $balanceRequest);


            if (!empty($request->roles)) {
                foreach ($request->roles as $role){
                    $userRoles[] = Role::whereId($role)->first();
                }
            }
            if(isset($userRoles) && !empty($userRoles)){
                $user->syncRoles($userRoles);
            }else{
                $user->syncRoles(null);
            }

            return redirect()->route('admin.settings.users.index')->withErrors([
                'success' => 'Usuário cadastrado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.users.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o usuário, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(!auth()->user()->hasPermissionTo('update_user')){
            abort(403);
        }

        $roles = Role::orderBy('name')->get();
        foreach ($roles as $role){
            if($user->hasRole($role->id)){
                $role->can = true;
            }else{
                $role->can = false;
            }
        }

        return view('admin.pages.settings.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(!auth()->user()->hasPermissionTo('update_user')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'email' => 'email:rfc|required|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|same:password_confirmation|max:15',
            'password_confirmation' => 'sometimes|required_with:password|max:15',
            'commission' => 'required|integer|between:0,100',
        ]);

        $indicador = $request->indicador;
        if($indicador == null || $indicador == 0){
            $indicador = 1;
        }

        try
        {
            $newBalance = 0;
            if($request->has('balance') && !is_null($request->balance)){
                $oldBalance = $user->balance;
                $balanceRequest = (float) Money::toDatabase($request->balance);
                $newBalanceRequest = $balanceRequest + (($user->commission/100) * $balanceRequest);
                $newBalance = $user->balance +  $newBalanceRequest;
            }

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            !empty($request->password) ? $user->password = bcrypt($request->password) : null;
            $user->status = isset($request->status) ? 1 : 0;
            $user->commission = $request->commission;
            $user->balance = $newBalance;
            $user->indicador = $indicador;
            $user->save();

            if((float) $newBalance > 0){
                $this->storeTransact($user, $newBalanceRequest, $oldBalance);
            }

            if (!empty($request->roles)) {
                foreach ($request->roles as $role){
                    $userRoles[] = Role::whereId($role)->first();
                }
            }
            if(isset($userRoles) && !empty($userRoles)){
                $user->syncRoles($userRoles);
            }else{
                $user->syncRoles(null);
            }

            return redirect()->route('admin.settings.users.index')->withErrors([
                'success' => 'Usuário alterado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.users.edit', ['user' => $user->id])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar o usuário, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!auth()->user()->hasPermissionTo('delete_user')){
            abort(403);
        }

        try {
            $user->delete();

            return redirect()->route('admin.settings.users.index')->withErrors([
                'success' => 'Usuário deletado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.users.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o usuário, tente novamente'
            ]);

        }
    }

    public function statementBalance($userId)
    {
        $historybalance = TransactBalance::with('user', 'userSender')
            ->where('user_id', $userId)
            ->paginate(10);

        if($historybalance->total() <= 0){
            $user = User::where('id', $userId)->first();
        }
        foreach ($historybalance as $h){
            $h->data = Carbon::parse($h->created_at)->format('d/m/y à\\s H:i');
            $h->responsavel = $h->userSender->name;
            $h->value = Money::toReal($h->value);
            $h->old_value = Money::toReal($h->old_value);
            $user = $h->user;
        }
        return view('admin.pages.settings.user.statementBalance', ['historybalance' => $historybalance, 'user' => $user]);
    }

    public function storeTransact(User $user, string $value, string $oldValue)
    {
        TransactBalance::create([
            'user_id_sender' => auth()->id(),
            'user_id' => $user->id,
            'value' => $value,
            'old_value' => $oldValue,
        ]);
    }
}
