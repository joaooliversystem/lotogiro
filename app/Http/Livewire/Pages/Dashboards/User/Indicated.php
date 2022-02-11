<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Indicated extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $indicated = User::where('indicador', auth()->id())->paginate(12);

        return view('livewire.pages.dashboards.user.indicated', ['indicateds' => $indicated]);
    }
}
