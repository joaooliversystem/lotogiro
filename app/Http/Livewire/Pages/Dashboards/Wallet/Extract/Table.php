<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Extract;

use App\Helper\Money;
use App\Helper\UserValidate;
use App\Models\TransactBalance;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use function App\Helper\UserValidate;

class Table extends Component
{
    use WithPagination;

    public $trasacts = [];
    public $paginate = [];

    public function mount()
    {
        $transacts = TransactBalance::with('user', 'userSender')
            ->where('user_id', auth()->id())
            ->paginate(10);

        $this->paginate['next'] = $transacts->nextPageUrl();
        $this->paginate['prev'] = $transacts->previousPageUrl();

        $transacts = $transacts->toArray();

        foreach ($transacts['data'] as $h){
            $this->trasacts[] = [
                'data' => Carbon::parse($h['created_at'])->format('d/m/y à\\s H:i'),
                'responsavel' => $h['user_sender']['name'],
                'value' => Money::toReal($h['value']),
                'old_value' => Money::toReal($h['old_value']),
                'obs' => $h['type']
            ];
        }
    }

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.extract.table', ['paginate' => $this->paginate]);
    }
}
