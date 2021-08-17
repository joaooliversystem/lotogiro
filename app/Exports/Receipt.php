<?php

namespace App\Exports;

use App\Models\Game;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class Receipt implements FromView
{
    use Exportable;

    public function view(): View
    {
        $game = Game::find(7);
        $typeGame = $game->typeGame;
        $typeGameValue = $game->typeGameValue;
        $client = $game->client;
        $numbers = explode(',', $game->numbers);
        asort($numbers, SORT_NUMERIC);

        return view('admin.layouts.pdf.receipt', compact('game', 'client', 'typeGame', 'numbers', 'typeGameValue'));

    }
}
