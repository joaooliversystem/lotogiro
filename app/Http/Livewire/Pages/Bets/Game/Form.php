<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;
use App\Models\Client;

class Form extends Component
{
    public $showList = false;
    public $clientId;
    public $typeGame;
    public $clients;
    public $numbers;
    public $matriz;
    public $selectedNumbers;
    public $values;
    public $selecionado = 0;
    public $search;


    public function mount($typeGame, $clients)
    {
        $this->selectedNumbers = [];
        if (!empty($typeGame)) {
            $this->typeGame = $typeGame;
            $this->clients = $clients;

            $this->numbers = $typeGame->numbers;
            $this->matriz($typeGame->numbers, $typeGame->columns);
        }

    }
    public function selecionaTudo(){
         $startnumberselected = 0;

        if($this->selecionado == 0){
         foreach ($this->selectedNumbers as $value) {
            array_pop($this->selectedNumbers);
        }
        for($i = 1;$i <= $this->typeGame->numbers; $i++){
        $startnumberselected = $i;
        array_push($this->selectedNumbers, $startnumberselected);
        }
        $this->selecionado = 1;
        $this->verifyValue();
         }

    }
     public function setId($client)
    {
            $this->clientId = $client["id"];
            $this->search = $client["name"] . ' - ' . $client["cpf"]. ' - ' . $client["email"]. ' - ' . $client["ddd"].' - ' . $client["phone"];
            $this->showList = false;

    }
    public function updatedSearch($value)
    {

            $this->clients = Client::where("name", "like", "{$this->search}%")->get();
            $this->showList = true;

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
