<?php

namespace App\Helper;

class Mask
{
    public static function addMask($data, $mask)
    {
        $data = str_split($data);
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset ($data[$k]))
                    $maskared .= $data[$k++];
            } else {
                if (isset ($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public static function addMaksPhone($phone){
        if(strlen($phone) == 10){
            $phone = self::addMask($phone, '(##)####-####');
        }else{
            $phone = self::addMask($phone, '(##)#####-####');
        }
        return $phone;
    }

    public static function addMaskCpf($cpf){

        $cpf = self::addMask($cpf, '###.###.###-##');

        return $cpf;
    }
}
