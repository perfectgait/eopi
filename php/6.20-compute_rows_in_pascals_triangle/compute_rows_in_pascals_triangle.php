<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;
use EOPI\Helper\OutputHelper;

/**
 * The time complexity is O(1) for each element so the overall complexity is O(1 + 2 + 3 ...) which is O(n^2)
 * (see http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/runsums/#section5.1).  The space complexity is O(n^2) to
 * store the result where n is the number of rows to generate.
 */

/**
 * Compute the first $n rows in Pascal's triangle.  This works by calculating each row from the values of the previous
 * row.  Each element in the row can be calculated by adding the adjacent elements in the previous row.
 *
 * i.e.
 * If the input is 4
 *
 * $result = []
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $result[0] = [1]
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 1;  Loop does not run for the first row
 *
 *      <<< FOR LOOP TERMINATION: $j > $i - 1 >>>
 *
 * $result = [
 *  [1]
 * ]
 *
 * Iteration 2:
 * $i = 1
 * $result[1] = [1, 1]
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 1; Loop does not run for the second row
 *
 *      <<< FOR LOOP TERMINATION: $j = $i - 1 >>>
 *
 * $result = [
 *  [1],
 *  [1, 1]
 * ]
 *
 * Iteration 3:
 * $i = 2
 * $result[2] = [1, 1, 1]
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 1
 *      $result[2][1] = 2
 *
 *      <<< FOR LOOP TERMINATION: $j = $i - 1 >>>
 *
 * $result = [
 *  [1],
 *  [1, 1],
 *  [1, 2, 1]
 * ]
 *
 * Iteration 4:
 * $i = 3
 * $result[3] = [1, 1, 1, 1]
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $j = 1
 *      $result[3][1] = 3
 *
 *      Iteration 2:
 *      $j = 2
 *      $result[3][2] = 3
 *
 *      <<< FOR LOOP TERMINATION: $j = $i - 1 >>>
 *
 * $result = [
 *  [1],
 *  [1, 1]
 *  [1, 2, 1]
 *  [1, 3, 3, 1]
 * ]
 *
 * <<< FOR LOOP TERMINATION: $i = $n - 1 >>>
 *
 * The first 4 rows are as follows:
 *
 *              1
 *          1       1
 *      1       2       1
 *  1       3       3       1
 *
 * @param int $n
 * @return array
 */
function computeNRowsInPascalsTriangle($n)
{
    if (!is_numeric($n) || $n < 1) {
        throw new \InvalidArgumentException('$n must be > 0');
    }

    $result = [];

    for ($i = 0; $i < $n; $i++) {
        $result[$i] = array_fill(0, $i + 1, 1);

        for ($j = 1; $j < $i; $j++) {
            $result[$i][$j] = $result[$i - 1][$j - 1] + $result[$i - 1][$j];
        }
    }

    return $result;
}

$inputHelper = new InputHelper();
$outputHelper = new OutputHelper();
$n = $inputHelper->readInputFromStdIn('Enter the non-negative number of rows of Pascal\'s triangle to generate: ');
$result = computeNRowsInPascalsTriangle($n);

printf('The first %d rows of Pascal\'s triangle are:', $n);
print PHP_EOL;
$outputHelper->printFormatted2DArrayToStdOut($result);
