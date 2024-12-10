<?php

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));

$trailheads = 0;
$paths = 0;

foreach ($grid as $x => $row) {
    foreach ($row as $y => $height) {

        if ($height != 0) continue;

        $peaks = [];

        $find = function ($location) use ($grid, &$peaks, &$find) {

            [$x, $y] = $location;
            $height = $grid[$x][$y];

            if ($height == 9) {
                $peaks[] = $location;
                return;
            }

            $neighbours = [[$x-1, $y], [$x, $y-1], [$x+1, $y], [$x, $y+1]];
            $filter = fn ($n) => isset($grid[$n[0]][$n[1]]) && $grid[$n[0]][$n[1]] == $height + 1;
            $available = array_filter($neighbours, $filter);

            if (count($available) === 0) {
                return;
            }

            foreach ($available as $neighbour) {
                $find($neighbour);
            }

        };

        $find([$x, $y]);

        $trailheads += count(array_unique($peaks, SORT_REGULAR));
        $paths += count($peaks);

    }
}

echo $trailheads.PHP_EOL;
echo $paths.PHP_EOL;