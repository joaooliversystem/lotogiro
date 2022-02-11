<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Helper\Money;
use App\Models\ModelHasRole;
use App\Models\TransactBalance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ManualRecharge extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $admins = ModelHasRole::with('user')->where('role_id', 1)->pluck('model_id');
        $transacts = TransactBalance::whereIn('user_id_sender', $admins)->orderByDesc('id')->paginate(10);

        $transacts->each(function($item, $key) {
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->value = Money::toReal($item->value);

            $received = User::find($item->user_id);
            $item->user = "{$received->name} {$received->last_name}";
        });

        return view('livewire.pages.dashboards.extract.manual-recharge', ['transacts' => $transacts]);

    }
}
