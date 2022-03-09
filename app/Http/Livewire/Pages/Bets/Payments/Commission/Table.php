<?php

namespace App\Http\Livewire\Pages\Bets\Payments\Commission;

use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $dateStart, $dateEnd, $users = [], $showList = false, $search, $userId, $auth, $perPage, $value, $valueBonus;

    public function mount()
    {
        $this->auth = auth()->user();
        $this->updatedSearch('Admin');
        if (empty($this->dateStart) && empty($this->dateEnd)) {
            $this->dateStart = Carbon::now()->startOfMonth()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->format('d/m/Y');
        }
        $this->perPage = session()->get('perPage', 10);
    }

    public function updatedSearch($value)
    {
        $this->users = User::where("name", "like", "%{$this->search}%")->get();
        $this->showList = true;
    }

    public function clearUser()
    {
        $this->reset(['search', 'userId']);
        $this->updatedSearch('Admin');
    }

    public function setId($user)
    {
        $this->userId = $user["id"];
        $this->search = $user["name"] . ' ' . $user["last_name"] . ' - ' . $user["email"];
        $this->showList = false;
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function pay()
    {
        $games = $this->runQueryBuilder()->get();

        if ($games->count() > 0) {
            foreach ($games as $game) {
                $game->commission_payment = true;
                $game->save();
                $result = ($game->commission_value ?? 0) + ($game->commision_value_pai ?? 0);
                $extract = [
                    'type' => 2,
                    'value' => $result,
                    'type_game_id' => $game->type_game_id,
                    'description' => 'Comissão - Jogo de id: ' . $game->id . ' Comissao de Nivel: ' . $game->commision_value_pai,
                    'user_id' => $game->user_id,
                    'client_id' => $game->client_id
                ];
                /*
                $users = User::whereNotNull('bonus')->get();
                foreach ($users as $user) {
                $bonus = $user->bonus;
                $balance = $user->balance;
                $result = $balance + $bonus;
                $user->balance = $result;
                $user->bonus = 0;
                $user->save();
                }*/
                $storeExtact = ExtractController::store($extract);
            }
            session()->flash('success', 'Pagamentos baixados com sucesso!');
        } else {
            session()->flash('error', 'Não foram encontrados pagamentos para baixar!');
        }

        return redirect()->route('admin.bets.payments.commissions.index');
    }

    public function runQueryBuilder()
    {
        $query = Game::query();
        $filterRange = $this->filterRange();
        $query
            ->when($this->dateStart, fn($query, $search) => $query->whereDate('created_at', '>=', $filterRange['dateStart'])
                ->whereDate('created_at', '<=', $filterRange['dateEnd']));
        $query = $this->filterStatus($query);
        $query = $this->filterUser($query);
        $query = $this->sumValues($query);
        $query = $this->bonValues($query);
        return $query;
    }

    public function filterStatus($query)
    {
        $query->where('commission_payment', false);

        return $query;
    }

    public function filterRange()
    {
        $dateStart = Carbon::parse(strtotime(str_replace('/', '-', $this->dateStart)))->toDateString();
        $dateEnd = Carbon::parse(strtotime(str_replace('/', '-', $this->dateEnd)))->toDateString();

        return [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        ];
    }

    public function filterUser($query)
    {
        $query->when($this->userId, fn($query, $search) => $query->where('user_id', $this->userId));

        return $query;
    }

    public function sumValues($query)
    {
        $value = 0;

        foreach ($query->get() as $item) {
            $value += $item->commission_value;
        }

        $this->value = $value;

        return $query;
    }
     public function bonValues($query)
    {
        $value = 0;

        foreach ($query->get() as $item) {
            $value += $item->commision_value_pai;
        }

        $this->valueBonus = $value;

        return $query;
    }

    public function render()
    {
        return view('livewire.pages.bets.payments.commission.table', [
            "games" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
