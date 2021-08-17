<?php

namespace App\Http\Livewire\Pages\Bets\TypeGame;

use Livewire\Component;

class Form extends Component
{
    public $typeGameId, $name, $numbers, $columns, $color, $description, $matriz;

    protected $rules = [
        'name' => 'required',
        'numbers' => 'required|numeric|digits_between:1,10',
        'columns' => 'required|numeric|digits_between:1,10',
        'description' => 'nullable|max:150',
    ];

    public function mount($typeGame)
    {
        if (!empty($typeGame)) {
            $this->typeGameId = $typeGame->id;
            $this->name = $typeGame->name;
            $this->numbers = $typeGame->numbers;
            $this->columns = $typeGame->columns;
            $this->color = $typeGame->color;
            $this->description = $typeGame->description;

            $this->matriz();
        }
    }

    public function updatedNumbers()
    {
        if(!empty($this->columns)){
            $this->matriz();
        }
    }

    public function updatedColumns()
    {
        if(!empty($this->numbers)){
            $this->matriz();
        }
    }

    public function matriz()
    {
        $this->validate();

        $matriz = [];
        $line = [];
        $index = 0;
        $count = 0;

        foreach (range(1, $this->numbers) as $number) {
            if ($count < $this->columns) {
                $count++;
            } else {
                $index++;
                $count = 1;
            }
            $matriz[$index][] = array_push($line, $number);
        }

        $this->matriz = $matriz;
    }

    public function render()
    {
        return view('livewire.pages.bets.type-game.form');
    }
}
