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

$found = 0;
foreach($grid as $x => $row) {

    if ($x === 0 || $x === array_key_last($grid)) {
        continue;
    }

    foreach (array_keys($row, "A") as $y) {

        if ($y === 0 || $y === array_key_last($row)) {
            continue;
        }

        $words = [
            $grid[$x-1][$y-1] . $grid[$x+1][$y+1],
            $grid[$x-1][$y+1] . $grid[$x+1][$y-1]
        ];

        if (array_all($words, fn ($word) => in_array($word, ["SM", "MS"]))) {
            $found++;
        }
    }
}
echo $found.PHP_EOL;