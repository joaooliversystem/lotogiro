<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet;

use App\Helper\Money;
use App\Models\TransactBalance;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Convert extends Component
{
    use LivewireAlert;

    public $valueConvert;
    public $user;

    public function transferBalance(): void
    {
        $this->valueConvert = Money::toDatabase($this->valueConvert);
        $myOldBalance = $this->user->balance;
        $myOldBonus = $this->user->bonus;

        if($myOldBonus < $this->valueConvert){
            $this->alert('error', 'Valor precisa ser menor ou igual ao seu Bônus!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
        }

        if($myOldBonus >= $this->valueConvert) {
            $this->user->balance += ($this->valueConvert + ($this->valueConvert * ($this->user->commission/100)));
            $this->user->bonus -= $this->valueConvert;

            $this->user->save();

            $this->storeTransact($this->user, $this->valueConvert, $myOldBalance, "Saldo recebido a partir de Bônus.");

            $this->flash('success', 'Conversão realizada com sucesso!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ], route('admin.dashboards.wallet.index'));
        }
    }

    private function storeTransact(User $user, string $value, string $oldValue, string $type): void
    {
        TransactBalance::create([
            'user_id_sender' => $user->id,
            'user_id' => $user->id,
            'value' => $value,
            'old_value' => $oldValue,
            'type' => $type
        ]);
    }

    public function mount()
    {
        $this->user = auth()->user();
    }
    public function render()
    {
        return view('livewire.pages.dashboards.wallet.convert');
    }
}
