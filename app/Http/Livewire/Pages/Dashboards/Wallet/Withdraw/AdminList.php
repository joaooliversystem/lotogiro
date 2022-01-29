<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use App\Helper\Money;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AdminList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function withdrawDone($withdrawId)
    {
        WithdrawRequest::findOrFail($withdrawId)->update([
            'status' => 1
        ]);
    }

    public function render()
    {
        $withdraws = WithdrawRequest::with('user')
            ->paginate(10);
        $withdraws->each(function($item, $key){
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->responsavel = $item->user->name;
            $item->data = Money::toReal($item->value);
            $item->statusTxt = $item->status === 0 ? 'À fazer' : 'Feito';
        });

        return view('livewire.pages.dashboards.wallet.withdraw.admin-list', [
            'withdraws' => $withdraws
        ]);
    }
}
