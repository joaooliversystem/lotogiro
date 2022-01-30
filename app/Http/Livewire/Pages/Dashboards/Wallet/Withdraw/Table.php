<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use App\Helper\Money;
use App\Models\User;
use App\Models\WithdrawRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Table extends Component
{
    use LivewireAlert;

    public $user;
    public $userObj;
    public $userId;
    public $valueTransfer;
    public $pixSaque;

    public function requestWithdraw(): void
    {
        if($this->valueTransfer <= 0 || is_null($this->valueTransfer)){
            $this->alert('warning', 'Valor precisa ser maior que 0!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
        }

       if($this->valueTransfer > 0){
           WithdrawRequest::create([
               'user_id' => $this->userId,
               'value' => Money::toDatabase($this->valueTransfer)
           ]);

           $this->userObj->update([
               'pixSaque' => $this->pixSaque
           ]);

           $this->flash('success', 'Transferência realizada com sucesso!', [
               'position' => 'center',
               'timer' => '2000',
               'toast' => false,
               'timerProgressBar' => true,
               'allowOutsideClick' => false
           ], route('admin.dashboards.wallet.index'));
       }
    }

    public function mount(): void
    {
        $this->user = User::with('client')->find(auth()->id())->toArray();
        $this->userId = auth()->user()->id;
        $this->userObj = auth()->user();
        $this->pixSaque = $this->user['pixSaque'];

        if((empty($this->pixSaque) || is_null($this->pixSaque)) && !is_null($this->user['client'])){
            $this->pixSaque = $this->user['client']['pix'];
        }
    }

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.withdraw.table');
    }
}
