<?php

function test($test, $operators) {
    if (count($test) == 2) {
        return count(array_unique($test)) === 1;
    }

    return array_reduce($operators, validator($test, $operators), false);
}

function validator($test, $operators) {

    $result = array_shift($test);
    $left = array_shift($test);
    $right = array_shift($test);

    return fn($valid, $operator) => $valid || test([$result, $operator($left, $right), ...$test], $operators);
}

function solve ($tests, $operators) {
    return array_sum(array_column(array_filter($tests, fn ($test) => test($test, $operators)), 0));
}

$input = file_get_contents('input');
$tests = array_map(fn ($x) => array_map(intval(...), explode(" ", $x)), explode(PHP_EOL, $input));

$operators[] = fn ($a, $b) => $a + $b;
$operators[] = fn ($a, $b) => $a * $b;
$part1 = solve($tests, $operators);

$operators[] = fn ($a, $b) => $a . $b;
$part2 = solve($tests, $operators);

echo $part1.PHP_EOL;
echo $part2.PHP_EOL;