<?php

namespace App\Helper;

use App\Models\User;

class UserValidate
{
    public static function iAmAdmin()
    {
        $role = auth()->user()->roles()->get();
        return $role->contains('name', 'Administrador');
    }
}
