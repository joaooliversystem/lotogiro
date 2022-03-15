<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Models\TypeGame;
use Livewire\Component;

class Sales extends Component
{
    public $range = 0, $jogos, $jogoSelected;
    public function render()
    {
        $this->jogos = TypeGame::with('typeGameValues')->get();

        return view('livewire.pages.dashboards.extract.sales');
    }
}
