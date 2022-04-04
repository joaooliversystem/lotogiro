<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'last_name',
        'email',
        'ddd',
        'phone',
        'pix',
    ];

    public $timestamps = true;
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function extracts()
    {
        return $this->hasMany(Extract::class);
    }

    public function bet()
    {
        return $this->hasMany(Bet::class);
    }
}
