<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;
use EOPI\Helper\OutputHelper;

/**
 * The time complexity is O(N) where N = n^2 by iterating through the first floor(n / 2) rows.  The space complexity is
 * O(1).
 */

/**
 * Rotate an n x n 2D array 90 degrees clockwise.  This works by going around the edge and swapping the elements as
 * necessary.  It works as follows:
 *
 * - Move the next element in the left column into the next element in the top row.  This grabs from the bottom of
 *   the left column and works up.  This fills from the left of the top row and works right.
 *
 * - Move the next element in the bottom row into the next element in the left column.  This grabs from the right of the
 *   bottom row and works left.  This fills from the bottom of the left column and works up.
 *
 * - Move the next element in the right column into the next element in the bottom row.  This grabs from the top of the
 *   right column and works down.  This fills from the right of the bottom row and works left.
 *
 * - Move the next element in the top row into the next element in the right column.  This grabs from the left of the
 *   top and works right.  This fills from the top of the right column and works down.
 *
 * i.e.
 * If the input array is:
 * [1, 2, 3]
 * [4, 5, 6]
 * [7, 8, 9]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 0
 * $temp = 1
 * $array = [7, 2, 1]
 *          [4, 5, 6]
 *          [9, 8, 3]
 *
 * Iteration 2:
 * $j = 1
 * $temp = 2
 * $array = [7, 4, 1]
 *          [8, 5, 2]
 *          [9, 6, 3]
 *
 * <<< FOR LOOP TERMINATION: $j = 1 >>>
 *
 * <<< FOR LOOP TERMINATION: $i = 1 >>>
 *
 * $array = [7, 4, 1]
 *          [8, 5, 2]
 *          [9, 6, 3]
 *
 * @param array $array
 * @return array
 */
function rotateArrayClockwise($array)
{
    if (empty($array)) {
        throw new \RuntimeException('$array must not be empty');
    }

    for ($i = 0; $i < count($array) / 2; $i++) {
        for ($j = $i; $j < count($array) - 1 - $i; $j++) {
            $temp = $array[$i][$j];

            // Fill top row from left to right
            $array[$i][$j] = $array[count($array) - 1 - $j][$i];
            // Fill left column from bottom to top
            $array[count($array) - 1 - $j][$i] = $array[count($array) - 1 - $i][count($array) - 1 - $j];
            // Fill bottom row from right to left
            $array[count($array) - 1 - $i][count($array) - 1 - $j] = $array[$j][count($array) - 1 - $i];
            // Fill right column from top to bottom
            $array[$j][count($array) - 1 - $i] = $temp;
        }
    }

    return $array;
}

$inputHelper = new InputHelper();
$outputHelper = new OutputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the n x n 2D array to be rotated 90 degrees clockwise: '));
$result = rotateArrayClockwise($array);

print 'Rotating:' . PHP_EOL;
$outputHelper->printFormatted2DArrayToStdOut($array);
print 'Results In:' . PHP_EOL;
$outputHelper->printFormatted2DArrayToStdOut($result);
print PHP_EOL;