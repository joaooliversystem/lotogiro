<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use Livewire\Component;

class Table extends Component
{
    public $valueTransfer;

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.recharge.table');
    }
}
