<?php

function shift($line, $number) {
    array_unshift($line, ...array_fill(0, $number, ''));
    return $line;
}

function search($word, $line) {
    $line = implode("", $line);
    return substr_count($line, $word) + substr_count($line, strrev($word));
}

$word = 'XMAS';

$input = file_get_contents('input');

$grid = array_map(str_split(...), explode(PHP_EOL, $input));

$count = 0;
$count += array_sum(array_map(fn ($line) => search($word, $line), $grid));
$count += array_sum(array_map(fn ($line) => search($word, $line), array_map(null, ...$grid)));
$count += array_sum(array_map(fn ($line) => search($word, $line), array_map(null, ...array_map(shift(...), $grid, array_keys($grid)))));
$count += array_sum(array_map(fn ($line) => search($word, $line), array_map(null, ...array_map(shift(...), array_reverse($grid), array_keys($grid)))));

echo $count.PHP_EOL;