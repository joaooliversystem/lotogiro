<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_role')) {
            abort(403);
        }

        if ($request->ajax()) {
            $role = $this->role->get();
            return DataTables::of($role)
                ->addIndexColumn()
                ->addColumn('action', function ($role) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_role')) {
                        $data .= '<a href="' . route('admin.settings.roles.edit', ['role' => $role->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_role')) {
                        $data .= ' <button class="btn btn-sm btn-danger" id="btn_delete_role" role="' . $role->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_role"> <i class="far fa-trash-alt"></i></button>
                  ';
                    }
                    return $data;
                })
                ->editColumn('created_at', function ($role) {
                    return Carbon::parse($role->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.settings.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create_role')) {
            abort(403);
        }

        $permissions = Permission::orderBy('alias')->get();

        return view('admin.pages.settings.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create_role')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
        ]);

        try {

            $role = $this->role;
            $role->name = $request->name;
            $role->guard_name = 'admin';
            $role->save();

            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission) {
                    $rolePermissions[] = Permission::whereId($permission)->first();
                }
            }

                if (isset($rolePermissions) && !empty($rolePermissions)) {
                    $role->syncPermissions($rolePermissions);
                } else {
                    $role->syncPermissions(null);
                }

            return redirect()->route('admin.settings.roles.index')->withErrors([
                'success' => 'Função cadastrada com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.roles.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao cadastrar a função, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->hasPermissionTo('update_role')) {
            abort(403);
        }

        $permissions = Permission::orderBy('alias')->get();

        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission->id)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('admin.pages.settings.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (!auth()->user()->hasPermissionTo('update_role')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
        ]);

        try {
            $role->name = $request->name;
            $role->guard_name = 'admin';
            $role->save();

            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission) {
                    $rolePermissions[] = Permission::whereId($permission)->first();
                }
            }

            if (isset($rolePermissions) && !empty($rolePermissions)) {
                $role->syncPermissions($rolePermissions);
            } else {
                $role->syncPermissions(null);
            }

            return redirect()->route('admin.settings.roles.index')->withErrors([
                'success' => 'Função alterada com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.roles.edit')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar a função, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->hasPermissionTo('delete_role')) {
            abort(403);
        }

        try {
            $role->delete();

            return redirect()->route('admin.settings.roles.index')->withErrors([
                'success' => 'Função deletada com sucesso'
            ]);

        } catch (\Exception $exception) {
            return redirect()->route('admin.settings.roles.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar a função, tente novamente'
            ]);

        }
    }
}
