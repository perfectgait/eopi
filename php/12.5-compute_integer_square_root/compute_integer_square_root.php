<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(log $k) and the space complexity is O(1)
 */

/**
 * Compute the largest integer whose square is <= $k.  This works by first defining the boundaries of what could be the
 * answer.  The boundaries are set at 0 and $k to include every possible value.  The midway point is then found, similar
 * to binary search.  The square of the midway point is then compared with $k.  If the square of the midway point is >
 * $k, the value must be < the midway point and the $right value in the range is updated to be $midway - 1.  If the
 * square of the midway point is <= to $k, the value must be > the midway point and the $left value in the range is
 * updated to be $midway + 1.  This process continues until the $left value in the range is > the $right value in the
 * range.  When this is true, the range is empty and every value >= $left squared is > than $k.  Every value < $left
 * squared is also <= $k so $left - 1 squared is the closest to $k without going over.
 *
 * i.e.
 * If $k = 7
 *
 * $left = 0
 * $right = 7
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $midway = 3
 * Is 9 > 7? Yes
 * $right = 2
 *
 * Iteration 2:
 * $midway = 1
 * Is 1 > 7? No
 * $left = 2
 *
 * Iteration 3:
 * $midway = 2
 * Is 4 > 7? No
 * $left = 3
 *
 * <<< WHILE LOOP TERMINATION: $left > $right >>>
 *
 * return 2
 *
 * @param int $k
 * @return int
 */
function computeIntegerSquareRoot($k)
{
    $left = 0;
    $right = $k;

    while ($left <= $right) {
        $midway = floor(($right + $left) / 2);
        
        if ($midway * $midway > $k) {
            $right = $midway - 1;
        } else {
            $left = $midway + 1;
        }
    }

    return $left - 1;
}

$inputHelper = new InputHelper();
$k = $inputHelper->readInputFromStdIn('Enter the integer to find the square root for: ');
$result = computeIntegerSquareRoot($k);

printf('The largest integer whose square is less than or equal to %d is %d.', $k, $result);
print PHP_EOL;