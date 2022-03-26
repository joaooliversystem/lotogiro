<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typeGame()
    {
        return $this->belongsTo(TypeGame::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function typeGameValue()
    {
        return $this->belongsTo(TypeGameValue::class);
    }

    public function bet()
    {
        return $this->belongsTo(Bet::class);
    }
}
