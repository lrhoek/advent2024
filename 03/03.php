<?php
function op($state, $instruction) {
    list ($do, $sum) = $state;
    $operation = substr($instruction[0], 0, 3);
    $do &= $operation === "mul";
    $sum += $do ? (int) $instruction[1] * (int) $instruction[2] : 0;
    $do |= $operation === "do(";
    return [$do, $sum];
}

function run($memory, $pattern) {
    preg_match_all($pattern, $memory, $instructions, PREG_SET_ORDER);
    return array_reduce($instructions, op(...), [true, 0])[1];
}

$memory = file_get_contents('input');
echo run($memory, '/mul\((\d{1,3}),(\d{1,3})\)/').PHP_EOL;
echo run($memory, '/mul\((\d{1,3}),(\d{1,3})\)|do\(\)|don\'t\(\)/').PHP_EOL;