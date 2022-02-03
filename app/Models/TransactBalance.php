<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactBalance extends Model
{
    use HasFactory;

    public $table = 'transact_balance';
    protected $fillable = [
        'user_id_sender',
        'user_id',
        'value',
        'old_value',
        'type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userSender()
    {
        return $this->hasOne(User::class, 'id', 'user_id_sender');
    }
}
