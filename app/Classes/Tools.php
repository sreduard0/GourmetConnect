<?php

namespace App\Classes;

class Tools
{
    public function hash($value, $function)
    {
        switch ($function) {
            case 'encrypt':
                return bin2hex(openssl_encrypt($value, 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z'));
                break;
            case 'decrypt':
                return openssl_decrypt(hex2bin($value), 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z');

                break;
        }
    }
    //====================[Mascara para strings]===========================
    public function mask($mask, $str)
    {
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }
}
