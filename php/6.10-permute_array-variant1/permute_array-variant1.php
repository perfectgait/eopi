<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the storage complexity is O(1)
 */

/**
 * Reverse an array representing a permutation.  This works by iterating through the array of permutation positions and
 * following each subsequent permutation position until all permutation positions have been explored.  At each position,
 * the following position is recorded and is replaced with the current position.
 *
 * i.e.
 *
 * If the input permutation is [3, 0, 1, 2]
 *
 * $p = 0
 * $temp = 3
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $j = 0
 * $p = 3
 * $temp = 2
 * $permutation = [3, 0, 1, 0]
 *
 * Iteration 2:
 * $j = 3
 * $p = 2
 * $temp = 1
 * $permutation = [3, 0, 3, 0]
 *
 * Iteration 3:
 * $j = 2
 * $p = 1
 * $temp = 0
 * $permutation = [3, 2, 3, 0]
 *
 * Iteration 4:
 * $j = 1
 * $p = 0
 * $temp = 3
 * $permutation = [1, 2, 3, 0]
 *
 * <<< LOOP TERMINATION: All elements of the input array have been iterated through >>>
 *
 * $permutation = [1, 2, 3, 0]
 *
 * @param array $permutation
 * @return array
 * @throws \InvalidArgumentException
 * @see http://mathworld.wolfram.com/InversePermutation.html
 */
function reversePermutation($permutation)
{
    if (empty($permutation)) {
        throw new \InvalidArgumentException('$permutation may not be empty');
    }

    $p = 0;
    $temp = $permutation[$p];

    for ($i = 0; $i < count($permutation); $i++) {
        $j = $p;
        $p = $temp;
        $temp = $permutation[$p];
        $permutation[$p] = $j;
    }

    return $permutation;
}

$inputHelper = new InputHelper();
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the permutation in json format: '));
$result = reversePermutation($permutation);

printf(
    'The result of reversing the %s permutation is %s',
    json_encode($permutation),
    json_encode($result)
);
print PHP_EOL;