<?php

namespace App\Http\Livewire\Pages\Bets\Payments\Draw;

use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Models\Draw;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $dateStart, $dateEnd, $auth, $perPage, $value;

    public function mount()
    {
        $this->auth = auth()->user();
        if (empty($this->dateStart) && empty($this->dateEnd)) {
            $this->dateStart = Carbon::now()->startOfMonth()->format('d/m/Y');
            $this->dateEnd = Carbon::now()->format('d/m/Y');
        }
        $this->perPage = session()->get('perPage', 10);
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
                $game->prize_payment = true;
                $game->save();

                $extract = [
                    'type' => 2,
                    'value' => $game->premio,
                    'type_game_id' => $game->type_game_id,
                    'description' => 'Prêmio - Jogo de id: ' . $game->id,
                    'user_id' => $game->user_id,
                    'client_id' => $game->client_id
                ];

                
                $users = User::where([
                ['id', $game->user_id],
                ['type_client', 1],
                 ])->get();
                foreach ($users as $user) {
                $premio = $game->premio;
                $balance = $user->balance;
                $result = $balance + $premio;
                $user->balance = $result;
                $user->save();
                }
                $storeExtact = ExtractController::store($extract);
            }
            session()->flash('success', 'Pagamentos baixados com sucesso!');
        } else {
            session()->flash('error', 'Não foram encontrados pagamentos para baixar!');
        }

        return redirect()->route('admin.bets.payments.draws.index');
    }

    public function runQueryBuilder()
    {
        $query = Game::query();
        $filterRange = $this->filterRange();
        $query
            ->when($this->dateStart, fn($query, $search) => $query->whereDate('created_at', '>=', $filterRange['dateStart'])
                ->whereDate('created_at', '<=', $filterRange['dateEnd']));
        $query = $this->filterStatus($query);
        $query = $this->filterDraws($query);
        $query = $this->sumValues($query);
        return $query;
    }

    public function filterStatus($query)
    {
        $query->where('prize_payment', false);

        return $query;
    }

    public function filterDraws($query)
    {
        
        $draws = Draw::whereNotNull('games')->get();
        $array = [];

        if ($draws->count() > 0) {
            foreach ($draws as $draw) {
                $games = explode(',', $draw->games);
                foreach ($games as $game) {
                    array_push($array, $game);
                }
            }
                    
            $query->whereIn('id', $array);
        } else {
            $query->where('id', '<', 0);
        }

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
            $value += $item->premio;
        }

        $this->value = $value;

        return $query;
    }

    public function render()
    {
        return view('livewire.pages.bets.payments.draw.table', [
            "games" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
