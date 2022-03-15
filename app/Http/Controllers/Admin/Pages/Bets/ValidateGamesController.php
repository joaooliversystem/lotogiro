<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Game;
use App\Helper\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Commision;
use App\Models\Commission;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Models\Client;
use App\Models\Competition;
use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Illuminate\Support\Facades\Auth;

use PDF;


use Mail;

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
                    
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_bet" bet="' . $bet->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_bet"> <i class="far fa-trash-alt"></i></button>';
                    
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
        // PEGAR ID DO CLIENTE PARA BUSCAR APOSTAS DO MESMO
        $idCliente = $validate_game->id;

        if($validate_game->user->id != auth()->id())
            return redirect()->route('admin.bets.validate-games.index');
        return view('admin.pages.bets.validate_games.edit', compact('validate_game', 'idCliente'));
    }

    public function update(Bet $validate_game, Game $game, Request $request)
    {

        $balance = auth()->user()->balance;
        $value = $request->valor;
        $ID_VALUE = auth()->user()->indicador;
        try {
            $date = Carbon::now();    
            if ( $date->hour >= 20 && $date->hour < 21) {
            throw new \Exception('Banca Fechada!');
       
        }
            $games = $validate_game->games;
            
            $balance = Balance::calculationValidation($value);
            if (!$balance) {
            throw new \Exception('Saldo Insufuciente!');
        }

          if ($games->count() > 0) {
                foreach ($games as $game) {
                    $commissionCalculation = Commision::calculationPai($game->commission_percentage, $game->value,$ID_VALUE);
                    $game->status = true;
                    $game->checked = 1;
                    $game->commision_value_pai = $commissionCalculation;
                    $game->save();
                    $extract = [
                    'type' => 1,
                    'value' => $game->value,
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

         // PEGAR ID DO CLIENTE PARA BUSCAR APOSTAS DO MESMO
        $idCliente = $validate_game->id;

        // pegando jogos feitos
        $jogosCliente = Game::where('bet_id', $idCliente)->get();
           
        // informações para filename
        $InfoJogos =  $jogosCliente[0];

        // pegando informações de cliente
        $ClientInfo = Client::where('id', $InfoJogos["client_id"])->get();
        $ClienteJogo =  $ClientInfo[0];

        // pegando typegame
        $TipoJogo = TypeGame::where('id', $InfoJogos['type_game_id'])->get();
        $TipoJogo = $TipoJogo[0];

        // pegando datas do sorteio
        $Datas = Competition::where('id', $InfoJogos['competition_id'])->get();
        $Datas = $Datas[0];

        // nome cliente
        $Nome = $ClienteJogo['name'] . ' ' . $ClienteJogo['last_name'];

        global $data;
        $data = [
            'prize' => false,
            'jogosCliente' => $jogosCliente,
            'Nome' => $Nome,
            'Datas' => $Datas,
            'TipoJogo' => $TipoJogo
        ];
        global $fileName;
        $fileName = 'Recibo ' . $InfoJogos['bet_id']  . ' - ' . $Nome . '.pdf';

        // return view('admin.layouts.pdf.receiptTudo', $data);
        global $pdf;
        $pdf = PDF::loadView('admin.layouts.pdf.receiptTudo', $data);
        // return $pdf->download($fileName);

        // $arquivo = $pdf->output($fileName);
        Mail::send('email.jogo', ['idjogo' => $game->id ], function($m){
            global $data;
            global $fileName;
            global $pdf;
            $m->from('admin@superlotogiro.com', 'SuperLotogiro');
            $m->subject('Seu Bilhete');
            $m->to(auth()->user()->email);
            $m->attachData($pdf->output(), $fileName);
        });

            session()->flash('success', 'Aposta validada com sucesso!');
            return redirect()->route('admin.bets.validate-games.edit', ['validate_game' => $validate_game->id]);
        } catch (\Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('admin.bets.validate-games.index');
        }
    }

    public function destroy($url)
    {
        $game = Game::where('bet_id', $url)->get();
        $idGame = '';
     
        foreach ($game as $games) {
            
           $idGame = $games->id;
           Game::destroy($idGame);
        }

       try {
            
            Bet::destroy($url);

            return redirect()->route('admin.bets.validate-games.index')->withErrors([
                'success' => 'Aposta Deletada com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.validate-games.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o sorteio, tente novamente'
            ]);

        }
    
    }
}
