<?php

namespace App\Http\Livewire\Pages\Dashboards\Extract;

use App\Models\Extract;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $range = 1, $dateStart, $dateEnd, $perPage = 10, $value;

    public function mount()
    {
        $this->perPage = session()->get('perPage', 10);
    }
    public function updatedRange($value)
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        session()->put('perPage', $value);
    }

    public function getReport()
    {
        $extracts = $this->runQueryBuilder()->get();

        $data = [
            'dateFilter' => $this->filterRange(),
            'extracts' => $extracts,
        ];

        $pdf = PDF::loadView('admin.layouts.pdf.extracts', $data)->output();

        $fileName = 'Relatório de Extrato - ' . Carbon::now()->format('d-m-Y h:i:s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf),
            $fileName
        );
    }

    public function runQueryBuilder()
    {
        $query = Extract::query();
        $filterRange = $this->filterRange();
        $query
            ->when($this->range, fn($query, $search) => $query->whereDate('created_at', '>=', $filterRange['dateStart'])
                ->whereDate('created_at', '<=', $filterRange['dateEnd']));
        $query = $this->sumValues($query);
        return $query;
    }

    public function filterRange(): array
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

    public function sumValues($query)
    {
        $value = 0;
        $credit = 0;
        $debit = 0;

        foreach ($query->get() as $item) {
            if ($item->type == 1) {
                $credit += $item->value;
            } elseif ($item->type == 2) {
                $debit += $item->value;
            }
        }

        $this->value = $credit - $debit;

        return $query;
    }

    public function render()
    {
        return view('livewire.pages.dashboards.extract.table', [
            "extracts" => $this->runQueryBuilder()->paginate($this->perPage),
        ]);
    }
}
