<?php

namespace App\Http\Livewire\Site\Pages\Bets\Games\Bet;

use App\Http\Controllers\Site\Pages\Bets\GameController;
use App\Models\Client;
use App\Models\TypeGameValue;
use Livewire\Component;

class Create extends Component
{
    public $bet, $typeGame, $user, $cpf, $name, $last_name, $pix, $phone, $value;
    public $numbers, $matriz, $selectedNumbers, $values;

    protected $rules = [
        'value' => 'required'
    ];

    public function mount($bet, $typeGame)
    {
 
        $this->bet = $bet;
        $this->typeGame = $typeGame;
        $this->user = $bet->user;
        $this->selectedNumbers = [];
        //$this->selectedNumbers = [];
        $this->numbers = $typeGame->numbers;
        $this->matriz($typeGame->numbers, $typeGame->columns);
    }

    public function selectNumber($number)
    {
        if (in_array($number, $this->selectedNumbers)) {
            $key = array_search($number, $this->selectedNumbers);
            if ($key !== false) {
                unset($this->selectedNumbers[$key]);
            }
        } else {
            array_push($this->selectedNumbers, $number);
        }
        $this->verifyValue();

    }
    public function selecionaTudo(){
        $startnumberselected = 0;
        for($i = 1;$i <= $this->typeGame->numbers; $i++){
        $startnumberselected = $i;
         array_push($this->selectedNumbers, $startnumberselected);
        }
    }

    public function verifyValue()
    {
        $numbers = count($this->selectedNumbers);

        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $this->typeGame->id],
            ['numbers', $numbers],
        ])->get();

        if (!empty($typeGameValue)) {
            $this->values = $typeGameValue;
            $this->reset('value');
        }

    }

    public function matriz($numbers, $columns)
    {
        $matriz = [];
        $line = [];
        $index = 0;
        $i = 0;

        foreach (range(1, $numbers) as $number) {
            if ($i < $columns) {
                $i++;
            } else {
                $index++;
                $i = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }

        $this->matriz = $matriz;
    }

    public function store()
    {
        $data = $this->validate();
        if (!empty($this->typeGame->competitions->last())) {
            try {
                $store = (new GameController())->store($this->bet, $this->typeGame, $this->selectedNumbers, $data);

                session()->flash('success', 'Jogo criado com sucesso!');
                return redirect()->route('games.bet', ['user' => $this->bet->user->id, 'bet' => $this->bet->id]);

            } catch (\Exception $exception) {
                session()->flash('error', config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro no processo!');
                return redirect()->route('games.bet', ['user' => $this->bet->user->id, 'bet' => $this->bet->id]);
            }
        }
    }

    public function render()
    {
        return view('livewire.site.pages.bets.games.bet.create');
    }
}
