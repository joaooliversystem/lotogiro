<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Illuminate\Http\Request;
use Livewire\Component;

class NumbersSelect extends Component
{
    public $numbers;
    public $typeGame;
    public $busca;
    public array $selectedNumbers = [];
    public bool $selecionado = false;

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

    public function selecionaTudo(){
        if(!$this->selecionado){
            foreach ($this->selectedNumbers as $value) {
                array_pop($this->selectedNumbers);
            }
            for($i = 1;$i <= $this->typeGame->numbers; $i++){
                $startnumberselected = $i;
                $this->selectedNumbers[] = $startnumberselected;
            }
            $this->selecionado = true;
            $this->verifyValue();
        }
    }

    public function randomNumbers($quantidadeAletorizar){
        $numerosAletatorios = array();
        $loopVezes = $quantidadeAletorizar;
        $rangeMax = $this->typeGame->numbers;

        for($i = 0; $i !== $loopVezes ; $i++){
            $addNumeroAleatorio =  rand(1, $rangeMax);
            // condição pra checar se o número já existe na lista
            while (in_array($addNumeroAleatorio, $numerosAletatorios, true)){
                $addNumeroAleatorio =  rand(1, $rangeMax);
            }
            $numerosAletatorios[] = $addNumeroAleatorio;
        }
        $this->selectedNumbers = $numerosAletatorios;
        $this->verifyValue();
    }

    public function selectNumber($number)
    {
        if(in_array($number, $this->selectedNumbers, true)){
            $key = array_search($number, $this->selectedNumbers, true);
            if($key!==false){
                unset($this->selectedNumbers[$key]);
            }
        }else{
            $this->selectedNumbers[] = $number;
        }
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

    public function mount(): void
    {
        $typeGame = TypeGame::with('competitions')->find(request('type_game'))->first();

        if(!empty($typeGame)){
            $this->typeGame = $typeGame;

            $this->numbers = $typeGame->numbers;
            $this->matriz($typeGame->numbers, $typeGame->columns);
        }
        $this->busca = TypeGameValue::select('numbers')
            ->where('type_game_id', $this->typeGame->id)
            ->orderBy('numbers', 'asc')
            ->get()->toArray();
    }

    public function render()
    {
        return view('livewire.pages.bets.game.numbers-select');
    }
}
