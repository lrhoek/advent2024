<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Crell\fp;
use Lrhoek\pf;

function solve(string $input, int $blinks) : int {
    return fp\pipe(
        $input,
        fp\explode(" "),
        array_count_values(...),
        pf\iterate(blink(...)),
        pf\ittake($blinks),
        fp\collect(...),
        fp\flatten(...),
        array_sum(...)
    );
}

function blink(array $pebbles) : array {
     return fp\reduceWithKeys([], map(...))($pebbles);
}

function map(array $pebbles, int $amount, int $number) : array {
    switch (0) {

        case $number:
            $pebbles = pf\add($pebbles, 1, $amount);
            break;

        case strlen((string) $number) % 2:
            $number = (string) $number;
            [$left, $right] = str_split($number, strlen($number) / 2);
            $pebbles = pf\add($pebbles, (int) $left, $amount);
            $pebbles = pf\add($pebbles, (int) $right, $amount);
            break;

        default:
            $pebbles = pf\add($pebbles, $number * 2024, $amount);
            break;
    }

    return $pebbles;
}

$input = file_get_contents('input');
echo solve($input, 25).PHP_EOL;
echo solve($input, 75).PHP_EOL;