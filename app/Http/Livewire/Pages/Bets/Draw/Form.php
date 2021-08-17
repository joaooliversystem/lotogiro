<?php

namespace App\Http\Livewire\Pages\Bets\Draw;

use App\Models\Draw;
use App\Models\Game;
use App\Models\TypeGame;
use Livewire\Component;

class Form extends Component
{

    public $typeGames, $typeGame, $competitions, $competition, $numbers, $games, $draw;

    protected $rules = [
        'typeGame' => 'required',
        'competition' => 'required|unique:App\Models\Draw,competition_id',
        'numbers' => 'required',
    ];

    public function mount($typeGames)
    {
        if (!empty(!$typeGames)) {
            $this->typeGames = $typeGames;
        }
    }

    public function updatedTypeGame()
    {
        if (!empty($this->typeGame)) {
            $typeGame = TypeGame::find($this->typeGame);
            $competitions = $typeGame->competitions;

            $this->competitions = $competitions;
        } else {
            $this->competitions = null;
        }
    }

    public function store()
    {
        $this->validate();

        $numbersDraw = explode(',', $this->numbers);
        $numbersDraw = array_filter($numbersDraw);
        $countNumbersDraw = count($numbersDraw);
        $selectGames = [];

        $games = Game::where([
            ['type_game_id', $this->typeGame],
            ['competition_id', $this->competition],
            ['status', true],
        ])->get();

        foreach ($games as $key => $game) {
            $countNumbersGame = 0;

            $game->numbers = explode(',', $game->numbers);

            foreach ($numbersDraw as $number) {
                $inArray = in_array($number, $game->numbers);
                if ($inArray)
                    $countNumbersGame++;
            }

            if ($countNumbersGame != $countNumbersDraw) {
                $games->forget($key);
            } else {
                array_push($selectGames, $game->id);
            }
        }

        $this->games = $games;

        $selectGames = implode(',', $selectGames);

        $draw = new Draw;
        $draw->type_game_id = $this->typeGame;
        $draw->competition_id = $this->competition;
        $draw->numbers = $this->numbers;
        $draw->games = !empty($selectGames) ? $selectGames : null;
        $draw->save();

        $this->draw = $draw;

        sleep(5);
    }

    public function render()
    {
        return view('livewire.pages.bets.draw.form');
    }
}
