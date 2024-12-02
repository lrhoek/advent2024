<?php

function ordered(array $numbers) : bool {
    $numbers_asc = $numbers_desc = $numbers;
    sort($numbers_asc);
    rsort($numbers_desc);
    return $numbers === $numbers_asc || $numbers === $numbers_desc;
}

function gradual(array $numbers) : bool {
    $numbers_shifted = $numbers;
    array_shift($numbers_shifted);
    array_pop($numbers);
    $gradual = array_map(fn ($a, $b) => abs($a - $b) >= 1 && abs($a - $b) <= 3, $numbers, $numbers_shifted);
    return !in_array(false, $gradual);
}

function safe(array $numbers) : bool {
    return ordered($numbers) && gradual($numbers);
}

function dampen(int $index, array $numbers) : bool {
    unset($numbers[$index]);
    return ordered(array_values($numbers)) && gradual($numbers);
}

function dampener ($numbers) : bool {
    return array_reduce(array_keys($numbers), fn ($safe, $index) => $safe || dampen($index, $numbers), false);
}

$input = file_get_contents('input');
$reports = array_map(fn ($report) => preg_split('/\s+/', $report), explode(PHP_EOL, $input));

echo count(array_filter(array_map(safe(...), $reports))).PHP_EOL;
echo count(array_filter(array_map(dampener(...), $reports))).PHP_EOL;