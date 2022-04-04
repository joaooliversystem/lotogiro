<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Helper\Money;
use App\Models\Draw;
use App\Models\Game;
use App\Models\TypeGame;
use Carbon\Carbon;
use Livewire\Component;

class Sales extends Component
{
    public $range = 0, $dateStart, $dateEnd, $jogos, $jogoSelected, $dados;

    public function mount()
    {
        $this->dateStart = Carbon::now()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
    }

    public function render()
    {
        $this->jogos = TypeGame::with('typeGameValues')->get();
        $now = Carbon::now();

        $periodo = [$now->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];

        if($this->range == 1){
            $periodo = [$now->subDay(1)->format('Y-m-d') . ' 00:00:00', $now->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 2){
            $periodo = [$now->subDays(7)->format('Y-m-d') . ' 00:00:00', $now->addDays(7)->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 3){
            $periodo = [$now->subDays(30)->format('Y-m-d') . ' 00:00:00', $now->addDays(30)->format('Y-m-d') . ' 23:59:59'];
        }
        if($this->range == 4){
            $periodo = [Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d') . ' 00:00:00',
                Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d') . ' 23:59:59'];
        }

        $games = Game::with('typeGame')
                ->whereBetween('created_at', $periodo)
                ->select(
                    'type_game_id',
                    \DB::raw('SUM(value) as gameValue'),
                    \DB::raw('COUNT(id) as gameCount')
                )
                ->groupBy('type_game_id')->get();

        $data = [];
        foreach($games as $game){
            $premiados = [];

            $draws = Draw::where('type_game_id', $game->type_game_id)
                        ->whereBetween('created_at', $periodo)
                        ->pluck('games');

            foreach($draws as $key => $draw){
                if (is_null($draw)) {
                    $draws->forget($key);
                }
                if (!is_null($draw)) {
                    foreach (explode(',', $draw) as $gameDraw) {
                        $premiados[] = $gameDraw;
                    }
                }
            }
            $gamesByUnity = Game::with('typeGameValue')
                ->whereBetween('created_at', $periodo)
                ->where('type_game_id', $game->type_game_id)
                ->select(
                    'type_game_value_id',
                    \DB::raw('SUM(value) as gameValue'),
                    \DB::raw('COUNT(id) as gameCount')
                )
                ->groupBy('type_game_value_id')->get();

            $game->unities = collect([]);
            $gamesByUnity->each(static function(Game $item) use($game, $premiados) {
                $drawedByUnity = Game::whereIn('id', $premiados)->get();

                $game->unities->push([
                    'dezenas' => $item->typeGameValue->numbers,
                    'vendido' => $item->gameCount,
                    'total' => "R$ " . Money::toReal($item->gameValue),
                    'drawed' => $drawedByUnity->where('type_game_value_id', $item->type_game_value_id)->count(),
                    'payed' => "R$ " . Money::toReal($drawedByUnity->where('type_game_value_id',
                            $item->type_game_value_id)->sum('premio'))
                ]);
            });

            $data[] = [
                'game' => $game->type_game_id,
                'gameName' => $game->typeGame->name,
                'gameColor' => $game->typeGame->color,
                'total' => $game->gameCount,
                'unities' => $game->unities,
                'payed' => "R$ " . Money::toReal($game->gameValue),
                'drawed' => count($premiados),
                'drawedPayed' => "R$ " . Money::toReal($game->whereIn('id', $premiados)->sum('premio')),
                'fullGain' => 'R$ ' . Money::toReal(($game->gameValue - $game->whereIn('id', $premiados)->sum
                ('premio'))),
            ];
        }

        $this->dados = collect($data);
        return view('livewire.pages.dashboards.extract.sales');
    }
}
