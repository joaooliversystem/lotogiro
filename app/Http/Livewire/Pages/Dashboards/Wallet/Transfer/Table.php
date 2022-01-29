<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Transfer;

use App\Helper\Money;
use App\Models\ClientContact;
use App\Models\TransactBalance;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Table extends Component
{
    use LivewireAlert;

    public $client;
    public $searchPhrase;
    public $valueTransfer;
    public $storeContact = true;

    protected $rules = [
        'searchPhrase' => 'required|min:6',
    ];

    public function searchClient(): void
    {
        $this->validate();
        $this->client = User::where('email', $this->searchPhrase)
            ->firstOrFail()->toArray();
    }

    public function transferBalance(): void
    {
        $myOldBalance = auth()->user()->balance;
        $oldBalanceClient = $this->client['balance'];
        $this->client['balance'] += (float) Money::toDatabase($this->valueTransfer);
        auth()->user()->balance -= (float) Money::toDatabase($this->valueTransfer);

        $client = User::find($this->client['id']);
        $client->balance = $this->client['balance'];

        $client->save();
        auth()->user()->save();

        $this->storeTransact(auth()->user(), $this->valueTransfer, $myOldBalance, "Saldo transferido para {$this->client['name']}");
        $this->storeTransact($client, $this->valueTransfer, $oldBalanceClient, "Saldo recebido de " .
                auth()->user()->name);

        if($this->storeContact){
            $this->storeContact($client);
        }

        $this->flash('success', 'Transferência realizada com sucesso!', [
            'position' => 'center',
            'timer' => '2000',
            'toast' => false,
            'timerProgressBar' => true,
            'allowOutsideClick' => false
        ], route('admin.dashboards.wallet.index'));
    }

    private function storeTransact(User $user, string $value, string $oldValue, string $type): void
    {
        TransactBalance::create([
            'user_id_sender' => auth()->id(),
            'user_id' => $user->id,
            'value' => Money::toDatabase($value),
            'old_value' => $oldValue,
            'type' => $type
        ]);
    }

    private function storeContact(User $user): void
    {
        $verifyContact = ClientContact::where([
                'user_id' => auth()->id(),
                'user_id_contact' => $user->id
            ])
            ->exists();

        if(!$verifyContact) {
            ClientContact::create([
                'user_id' => auth()->id(),
                'user_id_contact' => $user->id
            ]);
        }
    }


    public function render()
    {
        return view('livewire.pages.dashboards.wallet.transfer.table');
    }
}
