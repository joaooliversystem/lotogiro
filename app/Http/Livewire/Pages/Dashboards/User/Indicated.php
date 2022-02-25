<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithPagination;

class Indicated extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function redirectToRoute($userId): Redirector
    {
        return redirect()->route('admin.settings.users.indicatedByLevel', ['userId' => $userId]);
    }

    public function render()
    {
        $indicated = User::where('indicador', auth()->id())->paginate(12);

        return view('livewire.pages.dashboards.user.indicated', ['indicateds' => $indicated]);
    }
}
