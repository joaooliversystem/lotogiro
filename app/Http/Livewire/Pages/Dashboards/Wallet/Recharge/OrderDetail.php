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

        $allOrder->each(function($item, $key) use ($typeStatus) {
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->value = Money::toReal($item->value);
            $item->statusTxt = $typeStatus[$item->status];
        });

        $order = $allOrder->last();

        return view('livewire.pages.dashboards.wallet.recharge.order-detail', [
            'order' => $order,
            'allOrder' => $allOrder,
        ]);
    }
}
