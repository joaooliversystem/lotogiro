<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;

class Form extends Component
{
    public $typeGame;
    public $clients;
    public $numbers;
    public $matriz;
    public $selectedNumbers;
    public $values;

    public function mount($typeGame, $clients)
    {
        $this->selectedNumbers = [];
        for($i = 1;$i <= $typeGame->numbers; $i++){
        $startnumberselected = $i;
         array_push($this->selectedNumbers, $startnumberselected);
        }
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;

            $this->numbers = $typeGame->numbers;
            $this->matriz($typeGame->numbers, $typeGame->columns);
        }
    }

    public function selectNumber($number)
    {
        if(in_array($number, $this->selectedNumbers)){
            $key = array_search($number, $this->selectedNumbers);
            if($key!==false){
                unset($this->selectedNumbers[$key]);
            }
        }else{
            array_push($this->selectedNumbers, $number);
        }

        $this->verifyValue();

    }

    public function verifyValue()
    {
        $numbers = count($this->selectedNumbers);

        $typeGameValue = TypeGameValue::where([
            ['type_game_id', $this->typeGame->id],
            ['numbers', $numbers],
        ])->get();

        if( !empty($typeGameValue)){
            $this->values = $typeGameValue;
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

    public function render()
    {
        return view('livewire.pages.bets.game.form');
    }
}
