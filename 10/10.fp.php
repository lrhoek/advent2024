<?php

require_once 'vendor/autoload.php';

use Crell\fp;

function get($grid, $location) {
    [$x, $y] = $location;
    return $grid[$x][$y] ?? null;
}

function neighbours($location) {
    [$x, $y] = $location;
    return [[$x - 1, $y], [$x, $y - 1], [$x + 1, $y], [$x, $y + 1]];
}

function available($grid, $height) {
    return fn ($location) => get($grid, $location) == $height+1;
}

function find($grid) {
    return fn ($location) =>
        get($grid, $location) == 9
        ? [$location]
        : fp\pipe(
            $location,
            neighbours(...),
            fp\afilter(available($grid, get($grid, $location))),
            fp\amap(find($grid)),
            fp\reduce([], array_merge(...))
        );
}

$grid = fp\pipe(
    'input',
    file_get_contents(...),
    fp\explode(PHP_EOL),
    fp\amap(str_split(...))
);

[$trailheads, $paths] = fp\pipe(
    $grid,
    fp\amapWithKeys(
        fn ($row, $x) => fp\pipe(
            array_keys($row),
            fp\amap(fn ($y) => [$x, $y]),
            fp\afilter(fn ($location) => get($grid, $location) == 0)
        )
    ),
    fp\reduce([], array_merge(...)),
    fp\amap(find($grid)),
    fp\amap(fn ($peaks) => [count(array_unique($peaks, SORT_REGULAR)), count($peaks)]),
    fp\reduce([0, 0], fn ($count, $current) => [$count[0]+$current[0], $count[1]+$current[1]])
);

echo $trailheads . PHP_EOL;
echo $paths . PHP_EOL;