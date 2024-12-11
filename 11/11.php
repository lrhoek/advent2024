<?php

$pebbles = array_count_values(explode(" ", file_get_contents('input')));

function blink($pebbles, $blinks) {

    $new = [];
    foreach ($pebbles as $number => $amount) {

        if ($number === 0) {
            $new[$number + 1] ??= 0;
            $new[$number + 1] += $amount;
        }

        elseif (strlen($number) % 2 === 0) {
            [$left, $right] = str_split($number, strlen($number) / 2);
            $new[(int) $left] ??= 0;
            $new[(int) $left] += $amount;
            $new[(int) $right] ??= 0;
            $new[(int) $right] += $amount;
        }

        else {
            $new[$number * 2024] ??= 0;
            $new[$number * 2024] += $amount;
        }
    }

    $blinks--;

    return ($blinks === 0) ? $new : blink($new, $blinks);

}

echo array_sum(blink($pebbles, 25)).PHP_EOL;
echo array_sum(blink($pebbles, 75)).PHP_EOL;