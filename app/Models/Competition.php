<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    public function typeGame()
    {
        return $this->belongsTo(TypeGame::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }
}
