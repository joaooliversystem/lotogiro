<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use App\Models\TypeGameValue;
use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

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
    public $teste;
    public $busca;

    public function setId($client)
    {
        $this->clientId = $client["id"];
        $this->search = $client["name"] . ' - ' . $client["cpf"]. ' - ' . $client["email"]. ' - ' . $client["ddd"].' - ' . $client["phone"];
        $this->showList = false;
    }

    public function updatedSearch($value)
    {
//        $this->clients = Client::where("name", "like", "%{$this->search}%")->get();
//        $this->showList = true;
    }

    public function mount($clients)
    {
        if (!empty($clients)) {
            $this->clients = $clients;
        }

        $this->teste = Auth::user()->toArray();
    }

    public function render()
    {
        return view('livewire.pages.bets.game.form', ['busca' => $this->busca]);
    }
}
