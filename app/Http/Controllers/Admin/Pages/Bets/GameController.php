<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Exports\Receipt;
use App\Helper\Balance;
use App\Helper\Commision;
use App\Helper\Mask;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commission;
use App\Models\Draw;
use App\Models\Game;
use App\Models\HashGame;
use App\Models\TypeGame;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GameController extends Controller
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function index(Request $request, $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('read_game')) {
            abort(403);
        }
        if ($request->ajax()) {
            $game = $this->game->whereRaw('type_game_id = ? and checked = 1', $typeGame);
            if (!auth()->user()->hasPermissionTo('read_all_games')) $game->where('user_id', auth()->id());
            $game->get();
            return DataTables::of($game)
                ->addIndexColumn()
                ->addColumn('action', function ($game) {
                    $data = '';
                    if (auth()->user()->hasPermissionTo('update_game')) {
                        $data .= '<a href="' . route('admin.bets.games.edit', ['game' => $game->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_game')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_game" game="' . $game->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_game"> <i class="far fa-trash-alt"></i></button>';
                    }
                    return $data;
                })
                ->addColumn('client_cpf', function ($game) {
                    return Mask::addMaskCpf($game->client->cpf);
                })
                ->addColumn('client', function ($game) {
                    return $game->client->name . ' ' . $game->client->last_name;
                })
                ->addColumn('user', function ($game) {
                    return $game->user->name . ' ' . $game->user->last_name;
                })
                ->addColumn('type', function ($game) {
                    return $game->typeGame->name;
                })
                ->editColumn('created_at', function ($game) {
                    return Carbon::parse($game->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bets.game.index', compact('typeGame'));
    }

    public function create(TypeGame $typeGame)
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $typeGames = TypeGame::get();
        $clients = Client::get();

        return view('admin.pages.bets.game.create', compact('typeGames', 'typeGame', 'clients'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'type_game' => 'required',
            'client' => 'required',
            'value' => 'required',
        ]);

        $request['sort_date'] = str_replace('/', '-', $request['sort_date']);
        $request['sort_date'] = Carbon::parse($request['sort_date'])->toDateTime();
        
       try {
            $date = Carbon::now();
             if ( $date->hour >=20 || $date->hour < 00) {
             return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                    'error' => 'Apostas Encerradas!'
                ]);
             }
        
            $balance = Balance::calculation($request->value);

            if (!$balance) {
                return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                    'error' => 'Saldo Insuficiente!'
                ]);
            }

            $competition = TypeGame::find($request->type_game)->competitions->last();

            if (empty($competition)) {
                return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                    'error' => 'Não existe concurso cadastrado!'
                ]);
            }

            $game = new $this->game;
            $game->client_id = $request->client;
            $game->user_id = auth()->id();
            $game->type_game_id = $request->type_game;
            $game->type_game_value_id =$request->valueId;
            $game->value = $request->value;
            $game->premio = $request->premio;
            $game->numbers = $request->numbers;
            $game->competition_id = $competition->id;
            $game->checked = 1;
            $game->commission_percentage = auth()->user()->commission;
            $game->save();

            $extract = [
                'type' => 1,
                'value' => $request->value,
                'type_game_id' => $game->type_game_id,
                'description' => 'Venda - Jogo de id: ' . $game->id,
                'user_id' => $game->user_id,
                'client_id' => $game->client_id
            ];
            $ID_VALUE = auth()->user()->indicador;
            $storeExtact = ExtractController::store($extract);
            $commissionCalculationPai = Commision::calculationPai($game->commission_percentage, $request->value,$ID_VALUE);
            $commissionCalculation = Commision::calculation($game->commission_percentage, $request->value);

            $game->commission_value = $commissionCalculation;
            $game->commision_value_pai = $commissionCalculationPai;
            $game->save();

            return redirect()->route('admin.bets.games.edit', ['game' => $game->id])->withErrors([
                'success' => 'Jogo cadastrado com sucesso'
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.bets.games.create', ['type_game' => $request->type_game])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o jogo, tente novamente'
            ]);
        }
    }

    public function createLink()
    {
        try {
            $makeHash = $this->makeHash();

            $hashGame = new HashGame();
            $hashGame->hash = $makeHash;
            $hashGame->user_id = auth()->id();
            $hashGame->save();

            return redirect()->route('admin.home')->withErrors([
                'messageHashGame' => 'Link criado com sucesso',
                'hash' => $hashGame->hash
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('admin.home')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o link para o jogo, tente novamente'
            ]);
        }

    }

    public function makeHash()
    {
        $length = 23;
        $hash = bin2hex(random_bytes($length));

        if (!$this->validHash($hash)) {
            $this->makeHash();
        }

        return $hash;
    }

    public function validHash($hash)
    {
        return empty(HashGame::where('hash', $hash)->first());
    }

    public function edit(Request $request, Game $game)
    {
        if (!auth()->user()->hasPermissionTo('update_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        $typeGame = $game->typeGame;
        $typeGameValue = $game->typeGameValue;
        $client = $game->client;
        $selectedNumbers = explode(',', $game->numbers);

        $matriz = [];
        $line = [];
        $index = 0;
        $i = 0;

        foreach (range(1, $typeGame->numbers) as $number) {
            if ($i < $typeGame->columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }
        $this->matriz = $matriz;

        return view('admin.pages.bets.game.edit', compact('game', 'matriz', 'selectedNumbers', 'typeGame', 'typeGameValue', 'client'));

    }

    public function destroy(Game $game)
    {
        if (!auth()->user()->hasPermissionTo('delete_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        try {
            $typeGame = $game->type_game_id;

            $draws = Draw::get();

            foreach ($draws as $draw) {
                $draw->games = explode(',', $draw->games);
                $gameDraw = in_array($game->id, $draw->games);

                if ($gameDraw)
                    throw new \Exception('Jogo vinculado em um sorteio');
            }

            $game->delete();

            return redirect()->route('admin.bets.games.index', ['type_game' => $typeGame])->withErrors([
                'success' => 'Jogo deletado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.games.index', ['type_game' => $typeGame])->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o jogo, tente novamente'
            ]);

        }
    }

    public function getReceipt(Game $game, $format, $prize = false)
    {
        if (!auth()->user()->hasPermissionTo('read_game')) {
            abort(403);
        }

        if (!auth()->user()->hasPermissionTo('read_all_games') && $game->user_id != auth()->id()) {
            abort(403);
        }

        $typeGame = $game->typeGame;
        $typeGameValue = $game->typeGameValue;
        $client = $game->client;
        $numbers = explode(',', $game->numbers);
        asort($numbers, SORT_NUMERIC);

        $matriz = [];
        $line = [];
        $index = 0;
        $count = 0;

        foreach ($numbers as $number) {
            if ($count < 10) {
                $count++;
            } else {
                $index++;
                $count = 1;
                $line = [];
            }
            array_push($line, $number);

            $matriz[$index] = $line;
        }

        $data = [
            'game' => $game,
            'client' => $client,
            'typeGame' => $typeGame,
            'numbers' => $numbers,
            'typeGameValue' => $typeGameValue,
            'matriz' => $matriz,
            'prize' => $prize,
        ];
        if ($format == "pdf") {
            $pdf = PDF::loadView('admin.layouts.pdf.receipt', $data);
            $fileName = 'Recibo ' . $game->id . ' - ' . $client->name . '.pdf';

            return $pdf->download($fileName);
        } elseif ($format == "txt") {
            $fileName = 'Recibo ' . $game->id . ' - ' . $client->name . '.txt';
            $content = view()->make('admin.layouts.txt.receipt')->with($data);
            $headers = array(
                'Content-Type' => 'plain/txt',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            );

            return response()->make($content, 200, $headers);
        }
    }
}
