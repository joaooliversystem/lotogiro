<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeGameValue extends Model
{
    use HasFactory;

    public function typeGame()
    {
        return $this->belongsTo(TypeGame::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
