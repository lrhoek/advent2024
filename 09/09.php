<?php

class Space { public int $id = 0; public int $blocks; }
class File { public int $id; public int $blocks; public bool $checked = false; }

function map($key, $size) {

    if ($key % 2 === 0) {
        $o = new File();
        $o->id = $key / 2;
    }

    else {
        $o = new Space();
    }

    $o->blocks = $size;
    return $o;
}

$map = str_split(file_get_contents('input'));
$map = array_map(map(...), array_keys($map), $map);
$compacted = [];

$block = 0;
$checksum = 0;
while ($head = array_shift($map)) {

    if ($head->blocks === 0) continue;

    if ($head instanceof File) {
        $compacted[] = $head;
        continue;
    }

    while (end($map) instanceof Space) array_pop($map);

    if (count($map) === 0) continue;

    $file = array_pop($map);
    $move = min($head->blocks, $file->blocks);

    $head->blocks -= $move;
    array_unshift($map, $head);

    $file->blocks -= $move;
    $fragment = clone $file;
    $fragment->blocks = $move;

    $compacted[] = $fragment;

    if ($file->blocks > 0) $map[] = $file;
}

$block = 0;
$checksum1 = 0;
foreach ($compacted as $fragment) {
    for ($end = $block + $fragment->blocks; $block < $end; $block++) {
        $checksum1 += $block * $fragment->id;
    }
}

$map = str_split(file_get_contents('input'));
$map = array_map(map(...), array_keys($map), $map);

while (true) {
    $unchecked = array_filter($map, fn ($file) => $file instanceof File && !$file->checked);
    if (empty($unchecked)) break;

    $end_key = array_key_last($unchecked);
    $end = $map[$end_key];
    $end->checked = true;

    $mapper = fn ($space) => $space instanceof Space && $space->blocks >= $end->blocks;
    $key = array_key_first(array_filter($map, $mapper));

    if ($key === null || $key > $end_key) continue;
    $space = $map[$key];

    $map[$key] = $end;
    $remaining = new Space();
    $remaining->blocks = $space->blocks - $end->blocks;
    $space->blocks -= $remaining->blocks;

    $map[$end_key] = $space;
    array_splice($map, $key + 1, 0, [$remaining]);
}

$block = 0;
$checksum2 = 0;
foreach ($map as $fragment) {
    for ($end = $block + $fragment->blocks; $block < $end; ++$block) {
        $checksum2 += $block * $fragment->id;
    }
}
echo $checksum1.PHP_EOL;
echo $checksum2.PHP_EOL;