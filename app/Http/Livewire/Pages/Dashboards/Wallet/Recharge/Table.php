<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Recharge;

use App\Helper\Money;
use App\Models\RechargeOrder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class Table extends Component
{
    use LivewireAlert;

    public $valueAdd;

    public function callMP()
    {
        SDK::setAccessToken("APP_USR-2909617305972251-012203-1eb52e7fbfc50a7355b5beb6d5abbe79-1011031176"); // Either Production or SandBox AccessToken

        $preference = new Preference();
        $item = new Item();

        $item->title = "Recarga SuperLotogiro";
        $item->quantity = 1;
        $item->unit_price = (double) $this->valueAdd;

        $order = new RechargeOrder([
            'user_id' => auth()->id(),
            'value' => (double) $this->valueAdd,
            'status' => 0
        ]);
        $order->save();

        $preference->items = array($item);
        $preference->back_urls = [
            "success" => "https://superjogo.loteriabr.com/admin/dashboards/wallet/updateStatusPayment/",
            "failure" => "https://superjogo.loteriabr.com/dashboards/wallet/updateStatusPayment/",
            "pending" => "https://superjogo.loteriabr.com/dashboards/wallet/updateStatusPayment/"
        ];

        $preference->notification_url = "https://superjogo.loteriabr.com/";
        $preference->external_reference = $order->reference;
        $preference->save();

        $order->update(['link' => $preference->init_point]);

        $this->alert('info', 'Pronto!!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'html' => "Seu link para pagamento está pronto, gostaria de pagar agora?<br><br>
                        <a class='btn btn-block btn-outline-info'
                            onclick=redirect('{$preference->init_point}')>Sim</a>",
        ]);
    }

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.recharge.table');
    }
}
