<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Models\RechargeOrder;
use Livewire\Component;
use function view;

class OrderDetail extends Component
{
    public function render()
    {
        $order = RechargeOrder::where('reference', request('id'))->first();

        return view('livewire.pages.dashboards.wallet.recharge.order-detail', [
            'order' => $order
        ]);
    }
}
