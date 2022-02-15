<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Helper\Money;
use App\Helper\UserValidate;
use App\Models\RechargeOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use function App\Helper\UserValidate;
use App\Models\User;

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
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        if(UserValidate::iAmAdmin()){
            $allOrders = RechargeOrder::with('user')
                ->orderByDesc('id')
                ->paginate(10);
        }

        $allOrders->each(function($item, $key) use ($allOrders, $orders, $typeStatus) {

            if($orders->contains('reference', $item->reference)) {
                $allOrders->forget($key);
            }

            if(!$orders->contains('reference', $item->reference)) {
                $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
                $received = User::find($item->user_id);
                $item->user = "{$received->name} {$received->last_name}";
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
