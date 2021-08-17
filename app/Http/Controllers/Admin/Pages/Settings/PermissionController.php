<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('read_permission')){
            abort(403);
        }

        if ($request->ajax()) {
            $permission = $this->permission->get();
            return DataTables::of($permission)
                ->addIndexColumn()
                ->addColumn('action', function ($permission) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_permission')) {
                        $data .= '<a href="' . route('admin.settings.permissions.edit', ['permission' => $permission->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_permission')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_permission" permission="' . $permission->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_permission"> <i class="far fa-trash-alt"></i></button>
                   ';
                    }
                    return $data;
                })
                ->editColumn('created_at', function ($permission) {
                    return Carbon::parse($permission->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.settings.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_permission')){
            abort(403);
        }

        return view('admin.pages.settings.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('create_permission')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'menu' => 'required|max:50',
            'alias' => 'required|max:50',
        ]);

        try {
            $permission = $this->permission;
            $permission->name = $request->name;
            $permission->alias = $request->alias;
            $permission->menu = $request->menu;
            $permission->guard_name = 'admin';
            $permission->save();

            return redirect()->route('admin.settings.permissions.index')->withErrors([
                'success' => 'Permissão cadastrada com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.permissions.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao cadastrar a permissão, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if(!auth()->user()->hasPermissionTo('update_permission')){
            abort(403);
        }

        return view('admin.pages.settings.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if(!auth()->user()->hasPermissionTo('update_permission')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'menu' => 'required|max:50',
            'alias' => 'required|max:50',
        ]);

        try {
            $permission->name = $request->name;
            $permission->alias = $request->alias;
            $permission->menu = $request->menu;
            $permission->guard_name = 'admin';
            $permission->save();

            return redirect()->route('admin.settings.permissions.index')->withErrors([
                'success' => 'Permissão alterada com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.permissions.edit')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar a permissão, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if(!auth()->user()->hasPermissionTo('delete_permission')){
            abort(403);
        }

        try {
            $permission->delete();

            return redirect()->route('admin.settings.permissions.index')->withErrors([
                'success' => 'Permissão deletada com sucesso'
            ]);

        } catch (\Exception $exception) {
            return redirect()->route('admin.settings.permissions.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar a permissão, tente novamente'
            ]);

        }
    }
}
