<?php

namespace App\Http\Controllers\Site\Pages\Bets;

use App\Helper\Balance;
use App\Helper\Commision;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Game;
use App\Models\HashGame;
use App\Models\TypeGame;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class GameController extends Controller
{
    public function betIndex(User $user, Bet $bet = null)
    {
        $typeGames = TypeGame::get();
        return view('site.bets.games.bets.index', compact('user', 'bet', 'typeGames'));
    }

    public function betStore(User $user)
    {

        try {
            $date = Carbon::now();

            if ( $date->hour >=20 || $date->hour < 21) {
            $bet = null;
            $typeGames = TypeGame::get();
            session()->flash('error', 'Apostas Encerradas!');
            return view('site.bets.games.bets.index', compact('user', 'bet', 'typeGames'));

        }
            $bet = new Bet();
            $bet->user_id = $user->id;
            $bet->save();

            //session()->flash('success', 'Aposta criada com sucesso!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id]);
        } catch (Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id]);
        }
    }

    public function gameCreate($user, Bet $bet, TypeGame $typeGame)
    {

        return view('site.bets.games.bets.create', compact('bet', 'typeGame'));
    }

    public function store(Bet $bet, $typeGame, $selectedNumbers, $valor, $premio,$valueid)
    {

        if ($bet->status == false) {
          throw new \Exception('Aposta Já finalizada');
        }
            $date = Carbon::now();
            if ( $date->hour >=20 || $date->hour < 21) {
            throw new \Exception('Apostas encerradas');

        }
        sort($selectedNumbers, SORT_NUMERIC);
        $balance = Balance::calculationByHash($valor, $bet->user);

    //    if (!$balance) {
      //      throw new \Exception('Saldo Insufuciente!');
       // }

        $competition = TypeGame::find($typeGame->id)->competitions->last();

        if (empty($competition)) {
            throw new \Exception('Não existe concurso cadastrado!');
        }


        $validGame = Game::where([
            ['client_id', $bet->client->id],
            ['user_id', $bet->user->id],
            ['type_game_id', $typeGame->id],
            ['numbers', implode(',', $selectedNumbers)],
            ['bet_id', $bet->id],
        ])->first();

        if (!empty($validGame)) {
            throw new \Exception('Não é possivel cadastrar o mesmo jogo para está aposta!');
        }

        $game = new Game();
        $game->client_id = $bet->client->id;
        $game->user_id = $bet->user->id;
        $game->type_game_id = $typeGame->id;
        $game->type_game_value_id = $valueid;
        $game->value = $valor;
        $game->premio = $premio;
        $game->numbers = implode(',', $selectedNumbers);
        $game->competition_id = $competition->id;
        $game->commission_percentage = $bet->user->commission;
        $game->bet_id = $bet->id;
        $game->status = false;
        $game->save();

/*
        $extract = [
            'type' => 1,
            'value' => $game->typeGameValue->value,
            'type_game_id' => $game->type_game_id,
            'description' => 'Venda - Jogo de id: ' . $game->id,
            'user_id' => $game->user_id,
            'client_id' => $game->client_id
        ];

        $storeExtact = ExtractController::store($extract);*/

        $commissionCalculation = Commision::calculation($game->commission_percentage, $game->value);

        $game->commission_value = $commissionCalculation;
        $game->save();

        $bet->botao_finalizar = 0;
        $bet->save();

        return $game;


    }

    public function betUpdate(User $user, Bet $bet)
    {


        try {
            if($bet->botao_finalizar == 3){
                return view('site.bets.games.bets.bet-create', compact('bet'));
            }else{


            $bet->botao_finalizar = 3;
            $bet->status = false;
            $bet->save();
            return view('site.bets.games.bets.bet-create', compact('bet'));
             }
        } catch (Exception $exception) {
            session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
            return redirect()->route('games.bet', ['user' => $user->id, 'bet' => $bet->id]);
        }

    }

    public function setClient(Bet $bet, $clientId)
    {

        $bet->client_id = $clientId;
        $bet->save();

        return $bet;
    }

    public function validGame($game)
    {

    }
}
