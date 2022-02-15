<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    public $table = 'model_has_roles';
    protected $fillable = [
        'user_id',
        'role_id',
        'model_type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'model_id');
    }
}
