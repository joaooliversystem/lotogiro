<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Helper\Money;
use App\Models\RechargeOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $orders = collect([]);
        $typeStatus = [
            'Pendente', 'Aprovado', 'Cancelado', 'Falha'
        ];
        $allOrders = RechargeOrder::with('user')
            ->orderByDesc('id')
            ->paginate(10);


        $allOrders->each(function($item, $key) use ($allOrders, $orders, $typeStatus) {

            if($orders->contains('reference', $item->reference)) {
                $allOrders->forget($key);
            }

            if(!$orders->contains('reference', $item->reference)) {
                $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
                $item->value = Money::toReal($item->value);
                $item->statusTxt = $typeStatus[$item->status];

                $orders->push($item);
            }
        });

        return view('livewire.pages.dashboards.wallet.recharge.orders', [
            'orders' => $allOrders
        ]);
    }
}
