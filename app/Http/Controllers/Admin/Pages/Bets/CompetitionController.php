<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\TypeGame;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_competition')) {
            abort(403);
        }

        if ($request->ajax()) {
            $competition = Competition::get();
            return DataTables::of($competition)
                ->addIndexColumn()
                ->addColumn('action', function ($competition) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_competition')) {
                        $data .= '<a href="' . route('admin.bets.competitions.edit', ['competition' => $competition->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_competition')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_competition" competition="' . $competition->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_competition"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->editColumn('type_game', function ($competition) {
                    return $competition->typeGame->name;
                })
                ->editColumn('sort_date', function ($competition) {
                    return Carbon::parse($competition->sort_date)->format('d/m/Y H:i:s');
                })
                ->editColumn('created_at', function ($competition) {
                    return Carbon::parse($competition->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bets.competition.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create_competition')) {
            abort(403);
        }

        $typeGames = TypeGame::get();

        return view('admin.pages.bets.competition.create', compact('typeGames'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create_competition')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'number' => 'required|max:20',
            'type_game' => 'required|max:20',
            'sort_date' => 'required|date_format:d/m/Y H:i:s',
        ]);

        $request['sort_date'] = str_replace('/', '-', $request['sort_date']);
        $request['sort_date'] = Carbon::parse($request['sort_date'])->toDateTime();

        try {
            $competition = new Competition();
            $competition->number = $request->number;
            $competition->type_game_id = $request->type_game;
            $competition->sort_date = $request->sort_date;
            $competition->save();

            return redirect()->route('admin.bets.competitions.index')->withErrors([
                'success' => 'Concurso cadastrado com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.competitions.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao cadastrar o concurso, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Competition $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        if(!auth()->user()->hasPermissionTo('update_competition')){
            abort(403);
        }

        $competition->sort_date = Carbon::parse($competition->sort_date)->format('d/m/Y H:i:s');

        $typeGames = TypeGame::get();

        return view('admin.pages.bets.competition.edit', compact('competition', 'typeGames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Competition $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        if (!auth()->user()->hasPermissionTo('update_competition')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'number' => 'required|max:20',
            'type_game' => 'required|max:20',
            'sort_date' => 'required|date_format:d/m/Y H:i:s',
        ]);

        $request['sort_date'] = str_replace('/', '-', $request['sort_date']);
        $request['sort_date'] = Carbon::parse($request['sort_date'])->toDateTime();

        try {
            $competition->number = $request->number;
            $competition->type_game_id = $request->type_game;
            $competition->sort_date = $request->sort_date;
            $competition->save();

            return redirect()->route('admin.bets.competitions.index')->withErrors([
                'success' => 'Concurso atualizado com sucesso'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.competitions.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao atualizar o concurso, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Competition $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        if(!auth()->user()->hasPermissionTo('delete_competition')){
            abort(403);
        }

        try {
            $competition->delete();

            return redirect()->route('admin.bets.competitions.index')->withErrors([
                'success' => 'Concurso deletado com sucesso'
            ]);

        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.competitions.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o concurso, tente novamente'
            ]);

        }
    }
}
