<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the space complexity is O(1)
 */

/**
 * Generate an array who's spiral order is [1, 2, 3, ..., $dimension^2].  This works by starting at position [0][0] and
 * working around the edge in a clockwise fashion.  At each position the current value is placed and then the value is
 * incremented by one.  When the edge of a row or column is encountered, the direction is changed and the process
 * continues.
 *
 * i.e.
 * If the $dimension is 3
 *
 * // This is a fixed array in the implementation
 * $result = [
 *  [null, null, null],
 *  [null, null, null],
 *  [null, null, null],
 * ]
 * $x = 0
 * $y = 0
 * $shift = [
 *  [0, 1],
 *  [1, 0],
 *  [0, -1],
 *  [-1, 0]
 * ]
 * $direction = 0
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 1
 * $result = [
 *  [1, null, null],
 *  [null, null, null],
 *  [null, null, null],
 * ]
 * $nextX = 0
 * $nextY = 1
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? No
 * $x = 0
 * $y = 1
 *
 * Iteration 2:
 * $j = 2
 * $result = [
 *  [1, 2, null],
 *  [null, null, null],
 *  [null, null, null],
 * ]
 * $nextX = 0
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? No
 * $x = 0
 * $y = 2
 *
 * Iteration 3:
 * $j = 3
 * $result = [
 *  [1, 2, 3],
 *  [null, null, null],
 *  [null, null, null],
 * ]
 * $nextX = 0
 * $nextY = 3
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? Yes
 * $direction = 1 (01 & 11)
 * $nextX = 1
 * $nextY = 2
 * $x = 1
 * $y = 2
 *
 * Iteration 4:
 * $j = 4
 * $result = [
 *  [1, 2, 3],
 *  [null, null, 4],
 *  [null, null, null],
 * ]
 * $nextX = 2
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? No
 * $x = 2
 * $y = 2
 *
 * Iteration 5:
 * $j = 5
 * $result = [
 *  [1, 2, 3],
 *  [null, null, 4],
 *  [null, null, 5],
 * ]
 * $nextX = 3
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? Yes
 * $direction = 2 (10 & 11)
 * $nextX = 2
 * $nextY = 1
 * $x = 2
 * $y = 1
 *
 * Iteration 6:
 * $j = 6
 * $result = [
 *  [1, 2, 3],
 *  [null, null, 4],
 *  [null, 6, 5],
 * ]
 * $nextX = 2
 * $nextY = 0
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? No
 * $x = 2
 * $y = 0
 *
 * Iteration 7:
 * $j = 7
 * $result = [
 *  [1, 2, 3],
 *  [null, null, 4],
 *  [7, 6, 5],
 * ]
 * $nextX = 2
 * $nextY = -1
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? Yes
 * $direction = 3 (11 & 11)
 * $nextX = 1
 * $nextY = 0
 * $x = 1
 * $y = 0
 *
 * Iteration 8:
 * $j = 8
 * $result = [
 *  [1, 2, 3],
 *  [8, null, 4],
 *  [7, 6, 5],
 * ]
 * $nextX = 0
 * $nextY = 0
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? Yes
 * $direction = 0 (100 & 11)
 * $nextX = 1
 * $nextY = 1
 * $x = 1
 * $y = 1
 *
 * Iteration 9:
 * $j = 9
 * $result = [
 *  [1, 2, 3],
 *  [8, 9, 4],
 *  [7, 6, 5],
 * ]
 * $nextX = 1
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null? Yes
 * $direction = 1 (101 & 11)
 * $nextX = 2
 * $nextY = 1
 * $x = 2
 * $y = 1
 *
 * <<< FOR LOOP TERMINATION: $j = 9 >>>
 *
 * $result = [
 *  [1, 2, 3],
 *  [8, 9, 4],
 *  [7, 6, 5],
 * ]
 *
 * @param int $dimension
 * @return \SplFixedArray
 */
function generateSpiralArray($dimension)
{
    if ($dimension < 1 || $dimension > PHP_INT_MAX) {
        throw new \InvalidArgumentException('$dimension must be greater than 0 and >= ' . PHP_INT_MAX);
    }

    $result = new \SplFixedArray($dimension);

    for ($i = 0; $i < $dimension; $i++) {
        $result[$i] = new \SplFixedArray($dimension);
    }

    $x = 0;
    $y = 0;
    $shift = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0]
    ];
    $direction = 0;

    for ($j = 1; $j <= $dimension * $dimension; $j++) {
        $result[$x][$y] = $j;
        $nextX = $x + $shift[$direction][0];
        $nextY = $y + $shift[$direction][1];

        // Change direction
        if ($nextX < 0 || $nextX >= $dimension || $nextY < 0 || $nextY >= $dimension || $result[$nextX][$nextY] !== null) {
            // The bitwise & will ensure the direction is always in the set [0, 3]
            $direction = ($direction + 1) & 3;
            $nextX = $x + $shift[$direction][0];
            $nextY = $y + $shift[$direction][1];
        }

        $x = $nextX;
        $y = $nextY;
    }

    return $result;
}

$inputHelper = new InputHelper();
$dimension = $inputHelper->readInputFromStdIn('Enter the dimension of the matrix to generate: ');
$result = generateSpiralArray($dimension);

printf('The generated array with dimensions %d x %d is:', $dimension, $dimension);
print PHP_EOL;

for ($i = 0; $i < $dimension; $i++) {
    print '[';

    for ($j = 0; $j < $dimension; $j++) {
        print $result[$i][$j];

        if ($j != $dimension - 1) {
            print ',';
        }
    }

    print ']';
    print PHP_EOL;
}

print PHP_EOL;