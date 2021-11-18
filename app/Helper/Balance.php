<?php

namespace App\Helper;

use App\Models\TypeGameValue;
use App\Models\User;
use Carbon\Carbon;

class Balance
{
    public static function calculation($typeGameValue)
    {
        $response = false;
        //$typeGameValue = TypeGameValue::find($typeGameValue);

        $balance = auth()->user()->balance;

        //$result = $balance - $typeGameValue->value;
          $result = $balance - $typeGameValue;
        if($result >= 0){
           $user = User::find(auth()->id());
            $user->balance = $result;
            $user->save();

            $response = true;
        }

        return $response;

    }

    public static function calculationByHash($typeGameValue, $user)
    {
        $response = false;
        //$typeGameValue = TypeGameValue::find($typeGameValue);

        $balance = $user->balance;

        $result = $balance - $typeGameValue;

        if($result >= 0){
            /*
            $user = User::find($user->id);
            $user->balance = $result;
            $user->save();*/

            $response = true;
        }

        return $response;

    }
    
    public static function calculationValidation($typeGameValue)
    {
        $response = false;
        $balance = auth()->user()->balance;

        $result = $balance - $typeGameValue;

        if($result >= 0){
            $user = User::find(auth()->id());
            $user->balance = $result;
            $user->save();

            $response = true;
        }

        return $response;

    }
}
