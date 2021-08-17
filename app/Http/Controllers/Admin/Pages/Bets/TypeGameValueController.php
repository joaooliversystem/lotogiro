<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Money;
use App\Http\Controllers\Controller;
use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypeGameValueController extends Controller
{
    protected $typeGameValue;

    public function __construct(TypeGameValue $typeGameValue)
    {
        $this->typeGameValue = $typeGameValue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('read_type_game')) {
            abort(403);
        }

        if ($request->ajax()) {
            $typeGameValue = $this->typeGameValue->where('type_game_id', $typeGame->id)->get();
            return DataTables::of($typeGameValue)
                ->addIndexColumn()
                ->addColumn('action', function ($typeGameValue) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_type_game')) {
                        $data .= '<a href="' . route('admin.bets.type_games.values.edit', ['type_game' => $typeGameValue->type_game_id, 'value' => $typeGameValue->id]) . '" >
                                     <button type="button" class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                                  </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_type_game')) {
                        $data .= '<button type="button" class="btn btn-sm btn-danger" id="btn_delete_type_game_value" type_game="' . $typeGameValue->type_game_id . '" type_game_value="' . $typeGameValue->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_type_game_value"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->editColumn('value', function ($typeGameValue) {
                    return Money::toReal($typeGameValue->value);
                })
                ->editColumn('prize', function ($typeGameValue) {
                    return Money::toReal($typeGameValue->prize);
                })
                ->editColumn('created_at', function ($typeGameValue) {
                    return Carbon::parse($typeGameValue->created_at)->format('d/m/Y');
                })
                ->escapeColumns(['action'])
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('create_type_game')) {
            abort(403);
        }

        return view('admin.pages.bets.type_game.value.create', compact('typeGame'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('create_type_game')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'dozens' => 'required',
            'amount' => 'required',
            'prize' => 'required',
        ]);

        $request['dozens'] = preg_replace('/[^0-9]/', '', $request->dozens);
        $request['amount'] = Money::toDatabase($request->amount);
        $request['prize'] = Money::toDatabase($request->prize);

        try {
            $typeGameValue = new $this->typeGameValue;
            $typeGameValue->type_game_id = $typeGame->id;
            $typeGameValue->numbers = $request->dozens;
            $typeGameValue->value = $request->amount;
            $typeGameValue->prize = $request->prize;
            $typeGameValue->save();

            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'success' => 'Valor cadastrado com sucesso'
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o valor, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TypeGameValue $typeGameValue
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeGame $typeGame, TypeGameValue $value)
    {
        if (!auth()->user()->hasPermissionTo('update_type_game')) {
            abort(403);
        }

        return view('admin.pages.bets.type_game.value.edit', compact('value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TypeGameValue $typeGameValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeGame $typeGame, TypeGameValue $value)
    {
        if (!auth()->user()->hasPermissionTo('update_type_game')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'dozens' => 'required',
            'amount' => 'required',
            'prize' => 'required',
        ]);

        $request['dozens'] = preg_replace('/[^0-9]/', '', $request->dozens);
        $request['amount'] = Money::toDatabase($request->amount);
        $request['prize'] = Money::toDatabase($request->prize);

        try {
            $value->type_game_id = $typeGame->id;
            $value->numbers = $request->dozens;
            $value->value = $request->amount;
            $value->prize = $request->prize;
            $value->save();

            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'success' => 'Valor alterado com sucesso'
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.type_games.edit', ['type_game' => $typeGame->id])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar o valor, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TypeGameValue $typeGameValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeGame $typeGame, TypeGameValue $value)
    {
        if(!auth()->user()->hasPermissionTo('delete_type_game')){
            abort(403);
        }

        try {
            $value->delete();

            response()->json('success');
        } catch (\Exception $exception) {
            response()->json('error');
        }
    }
}
