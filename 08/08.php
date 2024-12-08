<?php

$ops = [
    fn ($a, $b, $multiplier = 1) => $a - $multiplier * $b,
    fn ($a, $b, $multiplier = 2) => $a + $multiplier * $b
];

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));
$antennas = [];

foreach ($grid as $x => $row) {
    foreach ($row as $y => $antenna) {
        if ($antenna === '.')  continue;
        $antennas[$antenna][] = [$x, $y];
    }
}

$max = array_key_last($grid);
$in_grid = fn ($antinode) => array_all($antinode, fn($c) => $c >= 0 && $c <= $max);

$antinodes = [];
$resonant = [];

foreach ($antennas as $type) {

    foreach ($type as $location) {

        foreach ($type as $search) {

            if ($location === $search) continue;

            $deltas = array_map(fn ($l, $s) => $s - $l, $location, $search);

            $potential = array_map(fn ($op) => array_map($op, $location, $deltas), $ops);
            array_push($antinodes, ...array_filter($potential, $in_grid));

            $multiplier = 0;
            while (++$multiplier) {

                $mapper = fn ($op) => array_map($op, $location, $deltas, [$multiplier, $multiplier]);
                $potential = array_map($mapper, $ops);

                if (empty($potential = array_filter($potential, $in_grid))) break;

                array_push($resonant, ...$potential);

            }
        }
    }
}

$antinodes = array_unique($antinodes, SORT_REGULAR);
$resonant = array_unique($resonant, SORT_REGULAR);

echo count($antinodes).PHP_EOL;
echo count($resonant).PHP_EOL;