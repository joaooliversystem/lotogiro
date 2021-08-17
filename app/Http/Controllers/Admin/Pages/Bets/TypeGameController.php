<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Http\Controllers\Controller;
use App\Models\TypeGame;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypeGameController extends Controller
{
    protected $typeGame;

    public function __construct(TypeGame $typeGame)
    {
        $this->typeGame = $typeGame;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_type_game')) {
            abort(403);
        }

        if ($request->ajax()) {
            $typeGame = $this->typeGame->get();
            return DataTables::of($typeGame)
                ->addIndexColumn()
                ->addColumn('action', function ($typeGame) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_type_game')) {
                        $data .= '<a href="' . route('admin.bets.type_games.edit', ['type_game' => $typeGame->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_type_game')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_type_game" type_game="' . $typeGame->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_type_game"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->editColumn('created_at', function ($typeGame) {
                    return Carbon::parse($typeGame->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bets.type_game.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create_type_game')) {
            abort(403);
        }

        return view('admin.pages.bets.type_game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create_type_game')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'numbers' => 'required|numeric|digits_between:1,10',
            'columns' => 'required|numeric|digits_between:1,10',
            'description' => 'nullable|max:200',
        ]);

        try {
            $typeGame = $this->typeGame;
            $typeGame->name = $request->name;
            $typeGame->numbers = $request->numbers;
            $typeGame->columns = $request->columns;
            $typeGame->color = !empty($request->color) ? $request->color : '#28a745';
            $typeGame->description = $request->description;
            $typeGame->save();

            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'success' => 'Tipo de Jogo cadastrado com sucesso'
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.type_games.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o tipo de jogo, tente novamente'
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TypeGame $typeGame
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('update_type_game')) {
            abort(403);
        }

        return view('admin.pages.bets.type_game.edit', compact('typeGame'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TypeGame $typeGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('update_type_game')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'numbers' => 'required|digits_between:1,10|numeric',
            'columns' => 'required|digits_between:1,10|numeric',
            'color' => 'required',
            'description' => 'nullable|max:200',
        ]);

        try {
            $typeGame->name = $request->name;
            $typeGame->numbers = $request->numbers;
            $typeGame->columns = $request->columns;
            $typeGame->color = $request->color;
            $typeGame->description = $request->description;
            $typeGame->save();

            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'success' => 'Tipo de Jogo alterado com sucesso'
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.type_games.edit')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar o tipo de jogo, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TypeGame $typeGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('delete_type_game')) {
            abort(403);
        }

        try {
            $typeGame->delete();

            return redirect()->route('admin.bets.type_games.index')->withErrors([
                'success' => 'Tipo de Jogo deletado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.type_games.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o tipo de jogo, tente novamente'
            ]);

        }
    }
}
