<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Transfer;

use App\Helper\Money;
use App\Models\Client;
use App\Models\User;
use Livewire\Component;

class Table extends Component
{
    public $client;
    public $searchPhrase;
    public $valueTransfer;

    protected $rules = [
        'searchPhrase' => 'required|min:6',
    ];

    public function searchClient(): void
    {
        $this->validate();
        $this->client = User::where('email', $this->searchPhrase)
//            ->orWhere('cpf', $this->searchPhrase)
            ->firstOrFail()->toArray();
    }

    public function transferBalance(): void
    {
        $oldBalance = $this->client['balance'];
        $this->client['balance'] += (float) Money::toDatabase($this->valueTransfer);
        auth()->user()->balance -= (float) Money::toDatabase($this->valueTransfer);

        $client = User::find($this->client['id']);
        $client->balance = $this->client['balance'];

        $client->save();
        auth()->user()->save();


        dd($this->client, auth()->user(), $client);
    }

    public function render()
    {
        return view('livewire.pages.dashboards.wallet.transfer.table');
    }
}
