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
        pf\iterate(fp\reduceWithKeys([], blink(...))),
        pf\ittake($blinks),
        fp\collect(...),
        fp\flatten(...),
        array_sum(...)
    );
}

function blink(array $pebbles, int $amount, int $number) : array {

    if ($number === 0) {
        $pebbles = pf\add($pebbles, 1, $amount);
    }

    elseif (strlen((string) $number) % 2 === 0) {
        [$left, $right] = str_split((string) $number, strlen((string) $number) / 2);
        $pebbles = pf\add($pebbles, (int) $left, $amount);
        $pebbles = pf\add($pebbles, (int) $right, $amount);
    }

    else {
        $pebbles = pf\add($pebbles, $number * 2024, $amount);
    }

    return $pebbles;
}

$input = file_get_contents('input');

echo solve($input, 25).PHP_EOL;
echo solve($input, 75).PHP_EOL;