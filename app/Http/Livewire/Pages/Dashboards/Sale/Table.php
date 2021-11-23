<?php

namespace App\Http\Livewire\Pages\Dashboards\Sale;

use App\Models\Game;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $auth;
    public $users = [];
    public $showList = false;
    public $search;
    public $userId;
    public $perPage = 10;
    public $range = 1;
    public $status = null;
    public $value;
    public $dateStart;
    public $dateEnd;
    public $i;
    public $sorts = [];
    public $filters = [
        "search" => null
    ];

    public function mount()
    {
        $this->auth = auth()->user();
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->updatedSearch('Admin');
        }
        $this->perPage = session()->get('perPage', 10);
    }

    public function updatedSearch($value)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->users = User::where("name", "like", "%{$this->search}%")->get();
            $this->showList = true;
        }
    }

    public function setId($user)
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->userId = $user["id"];
            $this->search = $user["name"] . ' ' . $user["last_name"] . ' - ' . $user["email"];
            $this->showList = false;
        }
    }

    public function clearUser()
    {
        if ($this->auth->hasPermissionTo('read_all_sales')) {
            $this->reset(['search', 'userId']);
            $this->updatedSearch('Admin');
        }
    }

    public function clearFilters()
    {
        $this->reset('filters');
    }

    public function sortBy($column)
    {
        if (!isset($this->sorts[$column])) return $this->sorts[$column] = 'desc';
        if ($this->sorts[$column] === 'desc') return $this->sorts[$column] = 'asc';
        unset($this->sorts[$column]);
    }

    public function applySorting($query)
    {
        foreach ($this->sorts as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        return $query;
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatedRange($value)
    {
        $this->resetPage();
    }

    public function updatedStatus($value)
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function updatedUser($value)
    {
        dd($value);
    }

    public function submit()
    {
        $dataValidated = $this->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required',
        ]);

    }

    public function filterRange()
    {
        $now = Carbon::now();
        switch ($this->range) {
            case 1:
                $dateStart = $now->startOfMonth()->toDateString();
                $dateEnd = $now->endOfMonth()->toDateString();
                break;
            case 2:
                $dateStart = $now->startOfWeek()->toDateString();
                $dateEnd = $now->endOfWeek()->toDateString();
                break;
            case 3:
                $dateStart = $now->startOfDay()->toDateString();
                $dateEnd = $now->endOfDay()->toDateString();
                break;
            case 4:
                $dateStart = Carbon::parse(strtotime(str_replace('/', '-', $this->dateStart)))->toDateString();
                $dateEnd = Carbon::parse(strtotime(str_replace('/', '-', $this->dateEnd)))->toDateString();
                break;
        }

        return [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        ];
    }

    public function filterUser($query)
    {

        $query
            ->when($this->userId, fn($query, $search) => $query->where('user_id', $this->userId));

        return $query;
    }

    public function filterStatus($query)
    {
        if (!empty($this->status)) {
            $status = $this->status == 1 ? false : true;
            $query->where('commission_payment', $status);
        }

        return $query;
    }

    public function sumValues($query, $id)
    {
         $value = 0;
        $row =  $query->where('user_id', $id)->count();
        //Game::where('user_id', $id)->count();
        if($row>0){
            
             $this->i = $query->where('checked', 1)->where('user_id', $id)->count();
             //Game::where('checked', 1)->where('user_id', $id)->count();
       
            $result = $query->where('checked', 1)->where('user_id', $id)->get();
            //Game::where('checked', 1)->where('user_id', $id)->get();
                foreach ($result as $item) {
            $value += $item->value;
            
            
        }
            
        }else{
            $value = 0;
            $this->i = 0;
        }

        $this->value = $value;

        return $query;
    }
     public function sumValuesTodos($query)
    {
             $this->i = $query->where('checked', 1)->count();
            // Game::where('checked', 1)->count();
             $value = 0;
       
            $result = $query->where('checked', 1)->get();
            //Game::where('checked', 1)->get();
                foreach ($result as $item) {
            $value += $item->value;
            
            
        }
            
        $this->value = $value;

        return $query;
    }
    public function sumValuesEscolhido($query, $id)
    {
         $value = 0;
        $row = $query->where('user_id', $id)->count();
        //Game::where('user_id', $id)->count();
        if($row>0){
            
             $this->i = $query->where('checked', 1)->where('user_id', $id)->count();
             //Game::where('checked', 1)->where('user_id', $id)->count();
       
            $result = $query->where('checked', 1)->where('user_id', $id)->get();
            //Game::where('checked', 1)->where('user_id', $id)->get();
                foreach ($result as $item) {
            $value += $item->value;
            
            
        }
            
        }else{
            $value = 0;
            $this->i = 0;
        }

        $this->value = $value;

        return $query;
    }

    public function runQueryBuilder()
    {
        $query = Game::query();
        if (!$this->auth->hasPermissionTo('read_all_sales')) {
            $query->where('user_id', $this->auth->id);
        }
        $filterRange = $this->filterRange();
        $query
            ->when($this->range, fn($query, $search) => $query->whereDate('created_at', '>=', $filterRange['dateStart'])
                ->whereDate('created_at', '<=', $filterRange['dateEnd']));
        $query = $this->filterUser($query);
        $query = $this->filterStatus($query);
        
         if (!$this->auth->hasPermissionTo('read_all_sales')) {
             $query = $this->sumValues($query, $this->auth->id);
            
        }else{
             
             if($this->userId != null){
                 $query = $this->sumValuesEscolhido($query, $this->userId);
             }else{
               $query = $this->sumValuesTodos($query);
           }
        }
            
        
        return $query; //$this->applySorting($query);
    }

    public function getReport()
    {
        $games = $this->runQueryBuilder()->with(['user', 'client', 'typeGameValue'])->get();
        $collection = new Collection();
        foreach ($games as $game) {
            $collection = $collection->push($game->toArray());
        }
        $collection = $collection->sortByDesc('client.name')->groupBy('user.name');

        $data = [
            'dateFilter' => $this->filterRange(),
            'collection' => $collection,
            'subtotal' => 0,
            'total' => 0
        ];

        $pdf = PDF::loadView('admin.layouts.pdf.sales', $data)->output();

        $fileName = 'Relatório de Vendas - ' . Carbon::now()->format('d-m-Y h:i:s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf),
            $fileName
        );
    }

    public function render()
    {
        return view('livewire.pages.dashboards.sale.table', [
            "games" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
