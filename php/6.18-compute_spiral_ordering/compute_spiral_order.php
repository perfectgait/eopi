<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the space complexity is O(1)
 */

/**
 * Compute the spiral order of an n x n matrix.  This works by calling computeSpiralOrderClockwise for each "ring" of
 * the matrix.
 *
 * i.e.
 * If the matrix is:
 * [
 *  [1, 2, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 *
 * The for loop will run from 0 - 1 because ceil(0.5 * 3) is 2.  This will compute the order of the outer "ring" and
 * then handle the remaining center element.
 *
 * @param array $matrix
 * @return array
 * @throws \InvalidArgumentException
 */
function computeSpiralOrder(array $matrix)
{
    if (empty($matrix)) {
        throw new \InvalidArgumentException('The $matrix cannot be empty');
    }

    $result = [];

    for ($offset = 0; $offset < ceil(0.5 * count($matrix)); $offset++) {
        computeSpiralOrderClockwise($matrix, $offset, $result);
    }

    return $result;
}

/**
 * Compute the spiral order of an n x n matrix in a clockwise fashion.   This works by adding the first n-$offset-1
 * elements of the first row of the matrix.  Then it adds the first n-$offset-1 elements of the last column of the
 * matrix.  Then it adds the last n-$offset-1 elements of the last row, in reverse order.  Finally it adds the last
 * n-$offset-1 elements of the first column, in reverse order.  If n is odd and the $offset is equal to the center of
 * the matrix, the center element is added only.
 *
 * i.e.
 * If the matrix is:
 * [
 *  [1, 2, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 * And the offset is 0
 *
 * $offset = 0
 * $result = []
 *
 * Is $offset == count($matrix) - $offset - 1? No
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * <<< FOR LOOP TERMINATION: $i = count($matrix) - $offset - 2 >>>
 *
 * Iteration 1:
 * $i = 0
 * $result = [1]
 *
 * Iteration 2:
 * $i = 1
 * $result = [1, 2]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 0
 * $result = [1, 2, 3]
 *
 * Iteration 2:
 * $j = 1
 * $result = [1, 2, 3, 6]
 *
 * <<< FOR LOOP TERMINATION: $j = count($matrix) - $offset - 2 >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $k = 2
 * $result = [1, 2, 3, 6, 9]
 *
 * Iteration 2:
 * $k = 1
 * $result = [1, 2, 3, 6, 9, 8]
 *
 * <<< FOR LOOP TERMINATION: $k = $offset + 1 >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $l = 2
 * $result = [1, 2, 3, 6, 9, 8, 7]
 *
 * Iteration 2:
 * $l = 1
 * $result = [1, 2, 3, 6, 9, 8, 7]
 *
 * <<< FOR LOOP TERMINATION: $l = $offset + 1 >>>
 *
 * $result = [1, 2, 3, 6, 9, 8, 7]
 *
 * =====================================================
 *
 * If the matrix is:
 * [
 *  [1, 2, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 * And the offset is 1
 *
 * $offset = 1
 * $result = []
 *
 * Is $offset == count($matrix) - $offset - 1? Yes
 * $result = [5]
 *
 * @param array $matrix
 * @param int $offset
 * @param array $result
 */
function computeSpiralOrderClockwise(array $matrix, $offset, array &$result)
{
    // Add the middle element
    if ($offset == count($matrix) - $offset - 1) {
        $result[] = $matrix[$offset][$offset];

        return;
    }

    // Add the n-$offset-1 elements from the first row
    for ($i = 0; $i < count($matrix) - $offset - 1; $i++) {
        $result[] = $matrix[$offset][$i];
    }

    // Add the n-$offset-1 elements of the last column
    for ($j = 0; $j < count($matrix) - $offset - 1; $j++) {
        $result[] = $matrix[$j][count($matrix) - $offset - 1];
    }

    // Add the n-$offset-1 elements of the last row, in reverse order
    for ($k = count($matrix) - $offset - 1; $k > $offset; $k--) {
        $result[] = $matrix[count($matrix) - $offset - 1][$k];
    }

    // Add the n-$offset-1 elements of the first row, in reverse order
    for ($l = count($matrix) - $offset - 1; $l > $offset; $l--) {
        $result[] = $matrix[$l][$offset];
    }
}

$inputHelper = new InputHelper();
$matrix = json_decode($inputHelper->readInputFromStdIn('Enter the 2D array representing the matrix in json format: '));
$result = computeSpiralOrder($matrix);

printf('The spiral order of %s is %s.', json_encode($matrix), json_encode($result));
print PHP_EOL;