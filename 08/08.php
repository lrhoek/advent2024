<?php

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));

$max = array_key_last($grid);
$in_grid = fn ($antinode) => array_all($antinode, fn($c) => $c >= 0 && $c <= $max);

$antennas = [];
$antinodes = [];
$resonants = [];

foreach ($grid as $x => $row) {
    foreach ($row as $y => $antenna) {
        if ($antenna === '.')  continue;
        $antennas[$antenna][] = [$x, $y];
    }
}

foreach ($antennas as $type) {

    foreach ($type as $location) {

        $resonants[] = $location;

        foreach ($type as $search) {

            if ($location === $search) continue;

            $delta = array_map(fn ($l, $s) => $s - $l, $location, $search);

            $multiplier = 0;
            while (++$multiplier) {

                $potential = array_map(fn ($a, $b) => $a + $multiplier * $b, $location, $delta);

                if (!$in_grid($potential)) break;

                if ($multiplier == 2) {
                    $antinodes[] = $potential;
                }

                $resonants[] = $potential;
            }
        }
    }
}

$antinodes = array_unique($antinodes, SORT_REGULAR);
$resonants = array_unique($resonants, SORT_REGULAR);

echo count($antinodes).PHP_EOL;
echo count($resonants).PHP_EOL;