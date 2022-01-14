<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use Livewire\Component;

class Table extends Component
{
    public $client;
    public $valueTransfer;

    public function mount()
    {
        $this->client = auth()->user()->toArray();
    }

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.withdraw.table');
    }
}
