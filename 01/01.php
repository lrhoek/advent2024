<?php

$input = file_get_contents('input');

$numbers = array_map(fn ($line) => preg_split('/\s+/', $line), explode(PHP_EOL, $input));
list($left, $right) = array_map(null, ...$numbers);
sort($left);
sort($right);
$diffs = array_map(fn ($a, $b) => abs($a - $b), $left, $right);
$similarities = array_map(fn ($a) => $a * count(array_keys($right, $a)), $left);

echo array_sum($diffs).PHP_EOL;
echo array_sum($similarities).PHP_EOL;
