<?php

function grid(string $input, string $separator) : array {
    return array_map(fn ($rule) => explode($separator, $rule), explode(PHP_EOL, $input));
}

function order(array $update, array $rules) : array {
    usort($update, fn ($a, $b) => in_array([$a, $b], $rules, true) ? -1 : 1);
    return $update;
}

function sums(array $sums, array $update, array $rules) : array {
    $ordered = order($update, $rules);
    $sums[$update === $ordered] += $ordered[intdiv(count($ordered), 2)];
    return $sums;
}

$input = explode(PHP_EOL.PHP_EOL, file_get_contents('input'));
list($rules, $updates) = array_map(grid(...), $input, ["|", ","]);

list($invalid, $valid) = array_reduce($updates, fn ($sums, $update) => sums($sums, $update, $rules), [0, 0]);

echo $valid.PHP_EOL;
echo $invalid.PHP_EOL;