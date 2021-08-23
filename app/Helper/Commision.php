<?php

namespace App\Helper;
use App\Models\User;
class Commision
{
    public static function calculation($percentage, $value)
    {
        $value = ($value / 100) * $percentage;

        return $value;
    }
    public static function calculationPai($percentage, $value, $ID_VALUE){

        $userPai = User::find($ID_VALUE);
        $comPai = $userPai->commission;
        $valorPai = 0;
        
        if($comPai == 25){
            if($percentage == 25){
                $result = $userPai->bonus + 0;
                $userPai->bonus = $result;
                $userPai->save();
                
            }else{
                $perPai = $comPai - $percentage;
                if($perPai = 10){
                    $perPai = 8.5;
                }else{
                    $perPai = 4.25;
                }
                $valorPai = ($value / 100) * $perPai;
                $result = $userPai->bonus + $valorPai;
                $userPai->bonus = $result;
                $userPai->save();
            }
        }
        if($comPai == 20){
            $idAvo = $userPai->indicador; 
            $userAvo = User::find($idAvo);
            if($idAvo == 1){
                $perPai = 4.25;
                $valorPai = ($value / 100) * $perPai;
                $result = $userPai->bonus + $valorPai;
                $userPai->bonus = $result;
                $userPai->save();
        
            }else if($userAvo->commission == 25){
                $commission = 4.25;
                $valor = ($value / 100) * $commission;
                $result = $userPai->bonus + $valor;
                $result2 = $userAvo->bonus + $valor;
                if($percentage == 20){
                    $valorPai = $valor;
                    $userAvo->bonus = $result2;
                    $userAvo->save();
                }else{
                $valorPai = $valor + $valor;
                $userPai->bonus = $result;
                $userPai->save();
                $userAvo->bonus = $result2;
                $userAvo->save();
                }

            }else{
                $result = $userPai->bonus + 0;
                $userPai->bonus = $result;
                $userPai->save();
            }
        
        }
        if($comPai == 15){
            $commission = 1.74;
            $valor = ($value / 100) * $commission;
            $valorPai = $valor;
            $result = $userPai->bonus + $valor;
            $userPai->bonus = $result;
            $userPai->save();
        }
        
        return $valorPai;
    }
}
