<?php

require_once 'vendor/autoload.php';

use Crell\fp;
use Lrhoek\pf;

function map($pebbles, $amount, $number) {
    return match (true) {
        $number === 0 => pf\addset($pebbles, 1, $amount),
        strlen($number) % 2 === 0 =>
            fp\pipe(
                str_split($number, strlen($number) / 2),
                fp\reduce($pebbles, fn ($new, $part) => pf\addset($new, (int) $part, $amount))
            ),
        default => pf\addset($pebbles, $number * 2024, $amount)
    };
}

function solve(string $input, int $blinks) {
    return fp\pipe(
        $input,
        fp\explode(" "),
        array_count_values(...),
        pf\iterate($blinks, fp\reduceWithKeys([], map(...))),
        array_sum(...)
    );
}

$input = file_get_contents('input');
echo solve($input, 25).PHP_EOL;
echo solve($input, 75).PHP_EOL;