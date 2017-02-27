<?php
namespace StudioVisual;

class Cpf
{
    /**
     * #### Method to iterate digits of a cpf
     *
     * @param $digits
     * @param int $positions
     * @param int $total
     * @return string
     */
    private static function positions($digits, $positions = 10, $total = 0)
    {
        for ($i = 0; $i < 9; $i++) {
            $total += $digits[$i] * $positions;
            $positions--;
        }
        $total %= 11;
        return $digits . $total = ($total < 2) ?
                $total = 0 :
                $total = 11 - $total;
    }

    /**
     * #### Method to validate a given cpf
     *
     * @param bool $cpf
     * @return bool
     */
    public static function validate($cpf = false)
    {
        if (!$cpf) {
            return false;
        }
        $invalids = [
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
        ];
        if (in_array($cpf, $invalids)) {
            return false;
        }
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        if (strlen($cpf) !== 11) {
            return false;
        }
        return self::positions(self::positions(substr($cpf, 0, 9)), 11) === $cpf ;
    }
}