<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;

    public function typeGame()
    {
        return $this->belongsTo(TypeGame::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
