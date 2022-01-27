<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeOrder extends Model
{
    use HasFactory;

    public $table = 'recharge_order';
    protected $fillable = [
        'reference',
        'user_id',
        'value',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
