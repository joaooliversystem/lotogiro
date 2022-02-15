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
    public $range = 0, $dateStart, $dateEnd, $perPage = 10, $value, $admins = [], $adminSelected = 0;

    public function render()
    {
        $admins = [];
        if($this->adminSelected != 0){
            $adms = null;
            $adms[] = $this->adminSelected;
        }

        if($this->adminSelected === 0){
            $adms = null;
            $roles = ModelHasRole::with('user')->where('role_id', 1)->get();

            $roles->each(function ($item, $key){
                $this->admins[] = [
                    'id' => $item->user->id,
                    'name' => $item->user->name . ' ' . $item->user->last_name
                ];
            });
            $adms = $roles->pluck('model_id')->toArray();
        }

        $transacts = TransactBalance::with('userSender', 'user')
            ->whereIn('user_id_sender', $adms)
            ->when($this->range > 0, function ($q) {
                $now = Carbon::now();
                if($this->range === '1'){
                    return $q->whereMonth('created_at', '=', $now->month);
                }
                if($this->range === '2'){
                    $this->dateStart = Carbon::now()->addDay()->format('Y-m-d');
                    $this->dateEnd = Carbon::now()->subDays(7)->format('Y-m-d');
                    return $q->whereBetween('created_at', [$this->dateEnd, $this->dateStart]);
                }
                if($this->range === '3'){
                    return $q->whereDay('created_at', $now);
                }
                if($this->range === '4'){
                    $dateStart = $this->dateStart;
                    $endStart = $this->dateEnd;
                    if(!Carbon::hasFormat($dateStart, 'Y-m-d')){
                        $dateStart = Carbon::createFromFormat('d/m/Y', $this->dateStart);
                    }
                    if(!Carbon::hasFormat($endStart, 'Y-m-d')){
                        $endStart = Carbon::createFromFormat('d/m/Y', $this->dateEnd);
                    }

                    return $q->whereBetween('created_at', [$dateStart, $endStart]);
                }
            })
            ->orderByDesc('id');

        $total = Money::toReal($transacts->sum('value'));
        $transacts = $transacts->paginate(10);
        $transacts->valueTotal = $total;

        $transacts->each(function($item, $key) use ($total) {
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->value = Money::toReal($item->value);

            $item->usuario = "{$item->user['name']} {$item->user['last_name']}";
            $item->responsavel = "{$item->userSender['name']} {$item->userSender['last_name']}";
        });

        return view('livewire.pages.dashboards.extract.manual-recharge', ['transacts' => $transacts]);
    }
}
