<?php

namespace App\Http\Livewire\Pages\Bets\Game;

use App\Models\TypeGame;
use Livewire\Component;

class GameCreate extends Component
{
    public int $typeGameSelected;
    public TypeGame $typeGames;
    public array $selectedNumbers = [];
    public array $matriz = [];

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

    public function mount()
    {
        $this->typeGameSelected = request('type_game');
        $this->typeGames = TypeGame::find($this->typeGameSelected)->first();

        if(!empty($this->typeGames)){
            $this->numbers = $this->typeGames->numbers;
            $this->matriz($this->typeGames->numbers, $this->typeGames->columns);
        }
    }

    public function render()
    {
        if (!auth()->user()->hasPermissionTo('create_game')) {
            abort(403);
        }

        return view('livewire.pages.bets.game.game-create')
            ->extends('admin.layouts.master');
    }
}
