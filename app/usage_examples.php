<?php

require __DIR__ . '/../vendor/autoload.php';

use Sif\SortedLinkedList\SortedLinkedList;

$list = SortedLinkedList::fromArray([1, 3, 5, 8]);

// Sum all elements in the list
$sum = $list->reduce(fn(int $carry, int $item): int => $carry + $item, 0); 

echo $sum . PHP_EOL;// 17 

// Find the maximum value (without initial value)
$max = $list->reduce(fn(int $carry, int $item): int => max($carry, $item));

echo $max . PHP_EOL; // 8
