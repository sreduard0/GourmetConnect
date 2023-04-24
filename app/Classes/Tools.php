<?php

namespace App\Classes;

class Tools
{
    // CRIPTOGRAFA VALORES
    public static function hash($value, $function)
    {
        if ($value) {
            switch ($function) {
                case 'encrypt':
                    return bin2hex(openssl_encrypt($value, 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z'));
                    break;
                case 'decrypt':
                    return openssl_decrypt(hex2bin($value), 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z');
                    break;
            }
        } else {
            return '';
        }

    }
    // MASCARA VALORES
    public static function mask($mask, $str)
    {
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }
    // GERA CORES A PARTIR DE UM VALOR
    public static function colorGenerate($value)
    {
        $hash = md5($value);
        return '#' . substr($hash, 0, 6);
    }
}
