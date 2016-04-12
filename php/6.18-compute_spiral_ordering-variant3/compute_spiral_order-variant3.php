<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(n) where n is the $number input
 */

/**
 * Generate a spiral array of ordered pairs starting from (0, 0).  This works by starting at (0, 0) and moving positive
 * on the x-axis until an edge is reached.  Then moving negative on the y-axis until an edge is reached.  Then moving
 * negative on the x-axis until an edge is reached.  Finally moving positive on the y-axis until an edge is reached.  At
 * that point the cycle continues.  An edge is detected by checking to see if either the x or y coordinate are > the
 * floor(width / 2).  For example if the width is 3 and x is 2 we know the direction needs to change because 2 > 1.
 * Every time the direction is 0 the width increases by 2 because a new edge has started.
 *
 * i.e.
 * If the input number is 10
 *
 * This is a fixed array in the implementation
 * $result = [null, null, null, null, null, null, null, null, null, null]
 * $x = 0
 * $y = 0
 * $shift = [
 *  [1, 0],
 *  [0, -1],
 *  [-1, 0],
 *  [0, 1]
 * ]
 * $direction = 0
 * $width = 3
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $result = ["(0, 0)", null, null, null, null, null, null, null, null, null]
 * $nextX = 1
 * $nextY = 0
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? No
 * $x = 1
 * $y = 0
 *
 * Iteration 2:
 * $i = 1
 * $result = ["(0, 0)", "(1, 0)", null, null, null, null, null, null, null, null]
 * $nextX = 2
 * $nextY = 0
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? Yes
 * $direction = 1 (01 & 11)
 * $nextX = 1
 * $nextY = -1
 * Is $direction == 0? No
 * $x = 1
 * $y = -1
 *
 * Iteration 3:
 * $i = 2
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", null, null, null, null, null, null, null]
 * $nextX = 1
 * $nextY = -2
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? Yes
 * $direction = 2 (10 & 11)
 * $nextX = 0
 * $nextY = -1
 * Is $direction == 0? No
 * $x = 0
 * $y = -1
 *
 * Iteration 4:
 * $i = 3
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", null, null, null, null, null, null]
 * $nextX = -1
 * $nextY = -1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? No
 * $x = -1
 * $y = -1
 *
 * Iteration 5:
 * $i = 4
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", null, null, null, null, null]
 * $nextX = -2
 * $nextY = -1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? Yes
 * $direction = 3 (11 & 11)
 * $nextX = -1
 * $nextY = 0
 * Is $direction == 0? No
 * $x = -1
 * $y = 0
 *
 * Iteration 6:
 * $i = 5
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", null, null, null, null]
 * $nextX = -1
 * $nextY = 1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? No
 * $x = -1
 * $y = 1
 *
 * Iteration 7:
 * $i = 6
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", "(-1, 1)", null, null, null]
 * $nextX = -1
 * $nextY = 2
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? Yes
 * $direction = 0 (100 & 011)
 * $nextX = 0
 * $nextY = 1
 * Is $direction == 0? Yes
 * $width = 5
 * $x = 0
 * $y = 1
 *
 * Iteration 8:
 * $i = 7
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", "(-1, 1)", "(0, 1)", null, null]
 * $nextX = 1
 * $nextY = 1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? No
 * $x = 1
 * $y = 1
 *
 * Iteration 9:
 * $i = 8
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", "(-1, 1)", "(0, 1)", "(1, 1)", null]
 * $nextX = 2
 * $nextY = 1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? No
 * $x = 2
 * $y = 1
 *
 * Iteration 10:
 * $i = 9
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", "(-1, 1)", "(0, 1)", "(1, 1)", "(2, 1)"]
 * $nextX = 3
 * $nextY = 1
 * Is abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)? Yes
 * $direction = 1 (101 & 011)
 * $nextX = 2
 * $nextY = 0
 * Is $direction == 0? No
 * $x = 2
 * $y = 0
 *
 * <<< FOR LOOP TERMINATION: $i = 9 >>>
 *
 * $result = ["(0, 0)", "(1, 0)", "(1, -1)", "(0, -1)", "(-1, -1)", "(-1, 0)", "(-1, 1)", "(0, 1)", "(1, 1)", "(2, 1)"]
 *
 * @param int $number
 * @return SplFixedArray
 */
function generateSpiralArrayOfOrderedPairs($number)
{
    if (!is_numeric($number) || $number < 1 || $number > PHP_INT_MAX) {
        throw new \InvalidArgumentException('$number must be between 1 and ' . PHP_INT_MAX . ' inclusive');
    }

    $result = new \SplFixedArray($number);
    $x = 0;
    $y = 0;
    $shift = [
        [1, 0],
        [0, -1],
        [-1, 0],
        [0, 1]
    ];
    $direction = 0;
    $width = 3;

    for ($i = 0; $i < $number; $i++) {
        $result[$i] = '(' . $x . ', ' . $y . ')';
        $nextX = $x + $shift[$direction][0];
        $nextY = $y + $shift[$direction][1];

        if (abs($nextX) > floor($width / 2) || abs($nextY) > floor($width / 2)) {
            $direction = ($direction + 1) & 3;
            $nextX = $x + $shift[$direction][0];
            $nextY = $y + $shift[$direction][1];

            if ($direction == 0) {
                $width += 2;
            }
        }

        $x = $nextX;
        $y = $nextY;
    }

    return $result;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter the number of pairs of integers to generate: ');
$result = generateSpiralArrayOfOrderedPairs($number);

printf('The generated array containing %d ordered pairs is: %s', $number, json_encode($result->toArray()));
print PHP_EOL;