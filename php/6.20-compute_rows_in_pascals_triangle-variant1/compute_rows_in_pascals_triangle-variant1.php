<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1) for each element so the overall complexity is O(1 + 2 + 3 ...) which is O(n^2)
 * (see http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/runsums/#section5.1).  The space complexity is O(n)
 */

/**
 * Compute the n-th row of Pascal's triangle.  This works by calculating the row from right to left so that the same
 * array can be used to calculate each row.  At the start of each outer for loop the row contains the previous rows
 * values.  The inner for loop calculates from right to left so the value at each iteration is $row[$j - 1] + $row[$j].
 * Each value in the inner for loop does not require any information from the right of it so the values being
 * overwritten will not be needed for the rest of the inner for loop.
 *
 * i.e.
 * If the input is 6
 *
 * $row = [1, 1, 1, 1, 1, 1]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = -1
 *
 *      <<< FOR LOOP TERMINATION: $j < 0 >>>
 *
 * $row = [1, 1, 1, 1, 1, 1]
 *
 * Iteration 2:
 * $i = 1
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 0
 *
 *      <<< FOR LOOP TERMINATION: $j = 0 >>>
 *
 * $row = [1, 1, 1, 1, 1, 1]
 *
 * Iteration 3:
 * $i = 2
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 1
 *      $row[1] = 1 + 1 = 2
 *
 *      <<< FOR LOOP TERMINATION: $j = 0 >>>
 *
 * $row = [1, 2, 1, 1, 1, 1]
 *
 * Iteration 4:
 * $i = 3
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 2
 *      $row[2] = 2 + 1 = 3
 *
 *      Iteration 2:
 *      $j = 1
 *      $row[1] = 1 + 2 = 3
 *
 *      <<< FOR LOOP TERMINATION: $j = 0 >>>
 *
 * $row = [1, 3, 3, 1, 1, 1]
 *
 * Iteration 5:
 * $i = 4
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 3
 *      $row[3] = 3 + 1 = 4
 *
 *      Iteration 2:
 *      $j = 2
 *      $row[2] = 3 + 3 = 6
 *
 *      Iteration 3:
 *      $j = 1
 *      $row[1] = 1 + 3 = 4
 *
 *      <<< FOR LOOP TERMINATION: $j = 0 >>>
 *
 * $row = [1, 4, 6, 4, 1, 1]
 *
 * Iteration 6:
 * $i = 5
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 4
 *      $row[4] = 4 + 1 = 5
 *
 *      Iteration 2:
 *      $j = 3
 *      $row[3] = 6 + 4 = 10
 *
 *      Iteration 3:
 *      $j = 2
 *      $row[2] = 4 + 6 = 10
 *
 *      Iteration 4:
 *      $j = 1
 *      $row[1] = 1 + 4 = 5
 *
 *      <<< FOR LOOP TERMINATION: $j = 0 >>>
 *
 * $row = [1, 5, 10, 10, 5, 1]
 *
 * <<< FOR LOOP TERMINATION: $i = $n - 1 >>>
 *
 * $row = [1, 5, 10, 10, 5, 1]
 * 
 * @param int $n
 * @return array
 */
function computeNthRowOfPascalsTriangle($n)
{
    if (!is_numeric($n) || $n < 1) {
        throw new \InvalidArgumentException('$n must be > 0');
    }

    $row = array_fill(0, $n, 1);

    for ($i = 0; $i < $n; $i++) {
        for ($j = $i - 1; $j > 0; $j--) {
            $row[$j] = $row[$j - 1] + $row[$j];
        }
    }

    return $row;
}

$inputHelper = new InputHelper();
$n = $inputHelper->readInputFromStdIn('Enter the non-negative number of the row of Pascal\'s triangle to generate: ');
$result = computeNthRowOfPascalsTriangle($n);

printf('The %d-th row of Pascal\'s triangle is: %s', $n, json_encode($result));
print PHP_EOL;