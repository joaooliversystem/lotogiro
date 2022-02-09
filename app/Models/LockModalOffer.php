<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockModalOffer extends Model
{
    use HasFactory;

    public $table = 'lock_modal_offer';
    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected $casts = [
        'status' => 'boolean',
    ];
}
