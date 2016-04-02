<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the space complexity is O(1)
 */

/**
 * Compute the spiral order of an n x n matrix.  This works by starting at position [0][0] and working around the edge
 * in a clockwise fashion.  When the edge of a row or column is encountered, the direction is changed and the process
 * continues.
 *
 * i.e.
 * If the matrix is:
 * [
 *  [1, 2, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 *
 * $shift = [[0, 1] ,[1, 0] ,[0, -1], [-1, 0]
 * $result = []
 * $x = 0
 * $y = 0
 * $direction = 0
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $result = [1]
 * $matrix = [
 *  [0, 2, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 * $nextX = 0
 * $nextY = 1
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? No
 * $x = 0
 * $y = 1
 *
 * Iteration 2:
 * $i = 1
 * $result = [1, 2]
 * $matrix = [
 *  [0, 0, 3],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 * $nextX = 0
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? No
 * $x = 0
 * $y = 2
 *
 * Iteration 3:
 * $i = 2
 * $result = [1, 2, 3]
 * $matrix = [
 *  [0, 0, 0],
 *  [4, 5, 6],
 *  [7, 8, 9]
 * ]
 * $nextX = 0
 * $nextY = 3
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? Yes
 * $direction = 1 (01 & 11)
 * $nextX = 1
 * $nextY = 2
 * $x = 1
 * $y = 2
 *
 * Iteration 4:
 * $i = 3
 * $result = [1, 2, 3, 6]
 * $matrix = [
 *  [0, 0, 0],
 *  [4, 5, 0],
 *  [7, 8, 9]
 * ]
 * $nextX = 2
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? No
 * $x = 2
 * $y = 2
 *
 * Iteration 5:
 * $i = 4
 * $result = [1, 2, 3, 6, 9]
 * $matrix = [
 *  [0, 0, 0],
 *  [4, 5, 0],
 *  [7, 8, 0]
 * ]
 * $nextX = 3
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? Yes
 * $direction = 2 (10 & 11)
 * $nextX = 2
 * $nextY = 1
 * $x = 2
 * $y = 1
 *
 * Iteration 6:
 * $i = 5
 * $result = [1, 2, 3, 6, 9, 8]
 * $matrix = [
 *  [0, 0, 0],
 *  [4, 5, 0],
 *  [7, 0, 0]
 * ]
 * $nextX = 2
 * $nextY = 0
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? No
 * $x = 2
 * $y = 0
 *
 * Iteration 7:
 * $i = 6
 * $result = [1, 2, 3, 6, 9, 8, 7]
 * $matrix = [
 *  [0, 0, 0],
 *  [4, 5, 0],
 *  [0, 0, 0]
 * ]
 * $nextX = 2
 * $nextY = -1
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? Yes
 * $direction = 3 (11 & 11)
 * $nextX = 1
 * $nextY = 0
 * $x = 1
 * $y = 0
 *
 * Iteration 8:
 * $i = 7
 * $result = [1, 2, 3, 6, 9, 8, 7, 4]
 * $matrix = [
 *  [0, 0, 0],
 *  [0, 5, 0],
 *  [0, 0, 0]
 * ]
 * $nextX = 0
 * $nextY = 0
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? Yes
 * $direction = 0 (100 & 011)
 * $nextX = 1
 * $nextY = 1
 * $x = 1
 * $y = 1
 *
 * Iteration 9:
 * $i = 8
 * $result = [1, 2, 3, 6, 9, 8, 7, 4, 5]
 * $matrix = [
 *  [0, 0, 0],
 *  [0, 0, 0],
 *  [0, 0, 0]
 * ]
 * $nextX = 1
 * $nextY = 2
 * Is $nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0? Yes
 * $direction = 1 (01 & 11)
 * $nextX = 2
 * $nextY = 1
 * $x = 2
 * $y = 1
 *
 * <<< FOR LOOP TERMINATION: $i = (count($matrix) * count($matrix)) - 1 >>>
 *
 * $result = [1, 2, 3, 6, 9, 8, 7, 4, 5]
 *
 * @param array $matrix
 * @return array
 */
function computeSpiralOrder(array $matrix)
{
    if (empty($matrix)) {
        throw new \InvalidArgumentException('The $matrix cannot be empty');
    }

    $shift = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0]
    ];
    $result = [];
    $x = 0;
    $y = 0;
    $direction = 0;

    for ($i = 0; $i < count($matrix) * count($matrix); $i++) {
        $result[] = $matrix[$x][$y];
        $matrix[$x][$y] = 0;
        $nextX = $x + $shift[$direction][0];
        $nextY = $y + $shift[$direction][1];

        if ($nextX < 0 || $nextX >= count($matrix) || $nextY < 0 || $nextY >= count($matrix) || $matrix[$nextX][$nextY] == 0) {
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
$matrix = json_decode($inputHelper->readInputFromStdIn('Enter the 2D array representing the matrix in json format: '));
$result = computeSpiralOrder($matrix);

printf('The spiral order of %s is %s.', json_encode($matrix), json_encode($result));
print PHP_EOL;