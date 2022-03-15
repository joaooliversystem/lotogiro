<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeGame extends Model
{
    use HasFactory;

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function hashGames()
    {
        return $this->hasMany(HashGame::class);
    }

    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    public function extracts()
    {
        return $this->hasMany(Extract::class);
    }
    public function typeGameValues()
    {
        return $this->hasMany(TypeGameValue::class);
    }
}
