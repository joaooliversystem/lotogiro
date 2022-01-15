<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    public $table = 'withdraw_request';
    protected $fillable = [
        'user_id',
        'value',
    ];
}
