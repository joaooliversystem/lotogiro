<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use App\Helper\Money;
use App\Models\LockBalance;
use App\Models\TransactBalance;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helper\UserValidate;

class AdminList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function withdrawDone($withdrawId)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($withdrawId);
        $withdrawRequest->update([
            'status' => 1
        ]);

        $userRequest = User::findOrFail($withdrawRequest->user_id);

        TransactBalance::create([
            'user_id_sender' => auth()->id(),
            'user_id' => $userRequest->id,
            'value' => $withdrawRequest->value,
            'old_value' => $userRequest->balance,
            'type' => 'Solicitação de saque finalizada.'
        ]);

        LockBalance::where('withdraw_request_id', $withdrawRequest->id)->first()->update([
            'status' => 1
        ]);
    }

    public function render()
    {
        $withdraws = WithdrawRequest::with('user')
            ->where('user_id', auth()->id())
            ->paginate(10);

        if(UserValidate::iAmAdmin()){
            $withdraws = WithdrawRequest::with('user')
                ->paginate(10);
        }

        $withdraws->each(function($item, $key){
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->responsavel = $item->user->name;
            $item->pix = $item->user->pixSaque;
            $item->value = Money::toReal($item->value);
            $item->statusTxt = $item->status === 0 ? 'À fazer' : 'Feito';
        });

        return view('livewire.pages.dashboards.wallet.withdraw.admin-list', [
            'withdraws' => $withdraws
        ]);
    }
}
