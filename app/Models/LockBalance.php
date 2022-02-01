<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockBalance extends Model
{
    use HasFactory;

    public $table = 'lock_balance';
    protected $fillable = [
        'value',
        'status',
        'withdraw_request_id',
    ];
}
