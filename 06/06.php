<?php

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));
$direction = [[-1, 0], [0, 1], [1, 0], [0, -1]];
$visited = [];

foreach (array_keys($grid) as $x) {
   if ($y = array_search('^', $grid[$x])) {
       $visited[] = [$x, $y];
       break;
   }
}

function run($grid, $visited, $direction, &$obstacles = []) : array {
    while (true) {
        list($x, $y) = array_map(array_sum(...), array_map(null, end($visited), current($direction)));

        if (!isset($grid[$x][$y])) {
            break;
        }

        if (in_array([$x, $y, key($direction)], $obstacles, true)) {
            $visited = [];
            break;
        }

        if ($grid[$x][$y] === '#') {
            $obstacles[] = [$x, $y, key($direction)];
            next($direction) ?: reset($direction);
            continue;
        }

        $visited[] = [$x, $y];
    }

    return array_map(unserialize(...), array_unique(array_map(serialize(...), $visited)));
}

function causes_loop($obstacle, $grid, $visited, $direction) : bool {
    list($x, $y) = $obstacle;
    $grid[$x][$y] = "#";
    return count(run($grid, $visited, $direction)) === 0;
}

$visited = run($grid, $visited, $direction);

echo count($visited).PHP_EOL;

$start = [array_shift($visited)];
$loops = array_filter($visited, fn ($obstacle) => causes_loop($obstacle, $grid, $start, $direction));

echo count($loops).PHP_EOL;