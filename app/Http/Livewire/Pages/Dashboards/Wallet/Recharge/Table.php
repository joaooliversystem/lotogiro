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
        SDK::setAccessToken("TEST-2909617305972251-012203-cf258239d677359e68197c8ab004e690-1011031176"); // Either Production or SandBox AccessToken

        $preference = new Preference();
        $item = new Item();

        $item->title = "Recarga Lotogiro";
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
            "success" => "http://lotogiro.pc/admin/dashboards/wallet/updateStatusPayment/",
            "failure" => "http://lotogiro.pc/admin/dashboards/wallet/updateStatusPayment/",
            "pending" => "http://lotogiro.pc/admin/dashboards/wallet/updateStatusPayment/"
        ];

        $preference->notification_url = "http://lotogiro.pc/";
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
