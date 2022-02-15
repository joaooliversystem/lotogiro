<?php

namespace App\Http\Livewire\Pages\Dashboards\Layouts;

use App\Models\LockModalOffer;
use Livewire\Component;

class ModalOffer extends Component
{
    public function closeModal($type = 0)
    {
        $lockModal = LockModalOffer::where('user_id', auth()->id())->first();
        $lockModal->status = 1;
        $lockModal->save();

        if($type === 1){
            $this->redirect(route('admin.dashboards.wallet.recharge'));
        }
    }

    public function render()
    {
        return view('livewire.pages.dashboards.layouts.modal-offer');
    }
}
