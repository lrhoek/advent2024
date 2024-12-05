<?php

function apply($a, $b, $rules) : int {
    return in_array([$a, $b], $rules) ? -1 : (in_array([$b, $a], $rules) ? 1 : 0);
}

function order($update, $rules) {
    usort($update, fn ($a, $b) => apply($a, $b, $rules));
    return $update;
}

list($rules, $updates) = explode(PHP_EOL.PHP_EOL, file_get_contents('input'));
$rules = array_map(fn ($rule) => explode("|", $rule), explode(PHP_EOL, $rules));
$updates = array_map(fn ($update) => explode(",", $update), explode(PHP_EOL, $updates));

$valid = array_filter($updates, fn ($update) => $update === order($update, $rules));
$valid_middles = array_map(fn ($update) => $update[intdiv(count($update), 2)], $valid);

$invalid = array_filter($updates, fn ($update) => $update !== order($update, $rules));
$invalid_ordered = array_map(fn ($update) => order($update, $rules), $invalid);
$invalid_ordered_middles = array_map(fn ($update) => $update[intdiv(count($update), 2)], $invalid_ordered);

echo array_sum($valid_middles).PHP_EOL;
echo array_sum($invalid_ordered_middles).PHP_EOL;