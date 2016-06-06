<?php

require_once '../bootstrap.php';

use \EOPI\Stack;

$stack = new Stack();
$stack->push(10);
$stack->push(5);
$stack->push(100);

print 'Max: ' . $stack->max() . PHP_EOL;
print 'Item: ' . $stack->pop() . PHP_EOL;
print 'Max: ' . $stack->max() . PHP_EOL;
