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
    return match (0) {
        $number => pf\addset($pebbles, 1, $amount),
        strlen((string) $number) % 2 => split($pebbles, (string) $number, $amount),
        default => pf\addset($pebbles, $number * 2024, $amount)
    };
}

function split(array $pebbles, string $number, int $amount) : array {
    return array_reduce(
        str_split($number, strlen($number) / 2),
        fn($new, $part) => pf\addset($new, (int) $part, $amount),
        $pebbles
    );
}

$input = file_get_contents('input');
echo solve($input, 25).PHP_EOL;
echo solve($input, 75).PHP_EOL;