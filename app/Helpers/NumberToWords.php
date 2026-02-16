<?php

namespace App\Helpers;

class NumberToWords
{
    private static $ones = [
        '',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'eleven',
        'twelve',
        'thirteen',
        'fourteen',
        'fifteen',
        'sixteen',
        'seventeen',
        'eighteen',
        'nineteen'
    ];

    private static $tens = [
        '',
        '',
        'twenty',
        'thirty',
        'forty',
        'fifty',
        'sixty',
        'seventy',
        'eighty',
        'ninety'
    ];

    public static function convert($number)
    {
        if ($number == 0) {
            return 'zero';
        }

        $number = number_format($number, 2, '.', '');
        list($rupees, $paise) = explode('.', $number);

        $rupees = (int) $rupees;
        $paise = (int) $paise;

        $words = '';

        if ($rupees > 0) {
            $words = self::convertToWords($rupees) . ' rupees';
        }

        if ($paise > 0) {
            if ($words != '') {
                $words .= ' and ';
            }
            $words .= self::convertToWords($paise) . ' paise';
        }

        return $words;
    }

    private static function convertToWords($number)
    {
        if ($number < 20) {
            return self::$ones[$number];
        }

        if ($number < 100) {
            return self::$tens[$number / 10] .
                (($number % 10 != 0) ? ' ' . self::$ones[$number % 10] : '');
        }

        if ($number < 1000) {
            return self::$ones[$number / 100] . ' hundred' .
                (($number % 100 != 0) ? ' ' . self::convertToWords($number % 100) : '');
        }

        if ($number < 100000) {
            return self::convertToWords($number / 1000) . ' thousand' .
                (($number % 1000 != 0) ? ' ' . self::convertToWords($number % 1000) : '');
        }

        if ($number < 10000000) {
            return self::convertToWords($number / 100000) . ' lakh' .
                (($number % 100000 != 0) ? ' ' . self::convertToWords($number % 100000) : '');
        }

        return self::convertToWords($number / 10000000) . ' crore' .
            (($number % 10000000 != 0) ? ' ' . self::convertToWords($number % 10000000) : '');
    }
}
