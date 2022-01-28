<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Helper\Money;
use App\Models\RechargeOrder;
use Carbon\Carbon;
use Livewire\Component;
use function view;

class OrderDetail extends Component
{
    public function render()
    {
        $typeStatus = [
            'Pendente', 'Aprovado', 'Cancelado', 'Falha'
        ];
        $allOrder = RechargeOrder::where('reference', request('id'))->get();

        $order = $allOrder->last();
        $order->value = Money::toReal($order->value);
        $order->data = Carbon::parse($order->created_at)->format('d/m/y à\\s H:i:s');
        $order->statusTxt = $typeStatus[$order->status];

        return view('livewire.pages.dashboards.wallet.recharge.order-detail', [
            'order' => $order,
            'allOrder' => $allOrder,
        ]);
    }
}
