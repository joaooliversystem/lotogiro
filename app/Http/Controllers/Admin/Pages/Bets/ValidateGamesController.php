<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Helper\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Commision;
use App\Models\Commission;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;

class ValidateGamesController extends Controller
{
    protected $bet;

    public function __construct(Bet $bet)
    {
        $this->bet = $bet;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bet = $this->bet->where([
                ['user_id', auth()->id()],
                ['status', false]
            ])->get();
            return DataTables::of($bet)
                ->addIndexColumn()
                ->addColumn('action', function ($bet) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_game')) {
                        $data .= '<a href="' . route('admin.bets.validate-games.edit', ['validate_game' => $bet->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_game')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_bet" game="' . $bet->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_bet"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->addColumn('client_cpf', function ($bet) {
                    return !empty($bet->client) ? Mask::addMaskCpf($bet->client->cpf) : null;
                })
                ->addColumn('client', function ($bet) {
                    return !empty($bet->client) ? $bet->client->name . ' ' . $bet->client->last_name : null;
                })
                ->editColumn('created_at', function ($bet) {
                    return Carbon::parse($bet->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bets.validate_games.index');
    }

    public function edit(Bet $validate_game)
    {
        if($validate_game->user->id != auth()->id())
            return redirect()->route('admin.bets.validate-games.index');
        return view('admin.pages.bets.validate_games.edit', compact('validate_game'));
    }

    public function update(Bet $validate_game,Request $request)
    {
        $balance = auth()->user()->balance;
        $value = $request->valor;
        $ID_VALUE = auth()->user()->indicador;
        try {
            $games = $validate_game->games;
            
            $balance = Balance::calculationValidation($value);
            if (!$balance) {
            throw new \Exception('Saldo Insufuciente!');
        }
            if ($games->count() > 0) {
                foreach ($games as $game) {
                    $commissionCalculation = Commision::calculationPai($game->commission_percentage, $game->typeGameValue->value,$ID_VALUE);
                    $game->status = true;
                    $game->checked = 1;
                    $game->commision_value_pai = $commissionCalculation;
                    $game->save();
                    $extract = [
                    'type' => 1,
                    'value' => $value,
                    'type_game_id' => $game->type_game_id,
                    'description' => 'Venda - Jogo de id: ' . $game->id,
                    'user_id' => $game->user_id,
                    'client_id' => $game->client_id
                ];
                $storeExtact = ExtractController::store($extract);
                }

                $validate_game->status = true;
                $validate_game->save();
            }

            session()->flash('success', 'Aposta validada com sucesso!');
            return redirect()->route('admin.bets.validate-games.index');
        } catch (\Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('admin.bets.validate-games.index');
        }
    }

    public function destroy()
    {

    }
}
