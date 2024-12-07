<?php

function test($equation, $operators) : bool {
    if (count($equation) == 2) {
        return count(array_unique($equation)) === 1;
    }

    $target = array_shift($equation);
    $left = array_shift($equation);
    $right = array_shift($equation);

    $validator = fn($operator) => test([$target, $operator($left, $right), ...$equation], $operators);

    return array_any($operators, $validator);
}

function solve ($equations, $operators) : int {
    return array_sum(array_column(array_filter($equations, fn ($equation) => test($equation, $operators)), 0));
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