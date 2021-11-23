<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactBalance extends Model
{
    use HasFactory;

    public $table = 'transact_balance';
    public $timestamps = true;
    protected $fillable = [
        'user_id_sender',
        'user_id',
        'value'
    ];
}
