<?php

namespace App\Http\Livewire\Pages\Dashboards\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithPagination;

class IndicatedByLevel extends Component
{
    use WithPagination;
    private $indicatedsArray = [];

    protected $paginationTheme = 'bootstrap';

    public function redirectToRoute($userId): Redirector
    {
        return redirect()->route('admin.settings.users.indicatedByLevel', ['userId' => $userId]);
    }

    public function getIndicateds(int $userId)
    {
        $this->indicatedsArray = User::where('indicador', $userId)->paginate(12);
    }

    public function mount()
    {
        $userIdRequest = request('userId');
        if($userIdRequest <= 0 || $userIdRequest == auth()->id()){
            abort(403);
        }
        if(count($this->indicatedsArray) <= 0) {
            $this->getIndicateds($userIdRequest);
        }
    }

    public function render()
    {
        return view('livewire.pages.dashboards.user.indicatedByLevel', [
            'indicateds' => $this->indicatedsArray
        ]);
    }
}
