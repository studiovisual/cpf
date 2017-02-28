<?php
namespace StudioVisual;

class Cpf
{
    public static function validate($cpf)
    {
        if (empty($cpf)) return false;
        $cpf = str_pad(preg_replace('/\D/is', '', $cpf), 11, '0', STR_PAD_LEFT);
        if (strlen($cpf) !== 11) return false;
        if (in_array($cpf, [
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999',
        ])) return false;
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) $d += $cpf{$c} * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ((int)$cpf{$c} !== $d) return false;
        }
        return true;
    }

    private static function mod($dividend, $divisor)
    {
        return round($dividend - (floor($dividend / $divisor) * $divisor));
    }

    public static function generate($mask = true)
    {
        $n1 = random_int(0, 9);
        $n2 = random_int(0, 9);
        $n3 = random_int(0, 9);
        $n4 = random_int(0, 9);
        $n5 = random_int(0, 9);
        $n6 = random_int(0, 9);
        $n7 = random_int(0, 9);
        $n8 = random_int(0, 9);
        $n9 = random_int(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - self::mod($d1, 11);
        if ($d1 >= 10) $d1 = 0;
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - self::mod($d2, 11);
        if ($d2 >= 10) $d2 = 0;
        $cpf = $mask ?
            '' . $n1 . $n2 . $n3 . '.' . $n4 . $n5 . $n6 . '.' . $n7 . $n8 . $n9 . '-' . $d1 . $d2 :
            '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
        return self::validate($cpf) ?
            $cpf :
            self::generate($mask);
    }
}