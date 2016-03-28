<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the storage complexity is O(n).
 */

/**
 * Check a Sudoku board to see if it is valid.  This works by looking at each row, each column and each sub-grid of the
 * board.  If there are any duplicates in the range [1, count($board)] then the board is invalid.  Otherwise, the board
 * is valid.
 *
 * i.e.
 * If the board is:
 * [
 *  [5,3,0,0,7,0,0,0,0],
 *  [6,0,0,1,9,5,0,0,0],
 *  [0,9,8,0,0,0,0,6,0],
 *  [8,0,0,0,6,0,0,0,3],
 *  [4,0,0,8,0,3,0,0,1],
 *  [7,0,0,0,2,0,0,0,6],
 *  [0,6,0,0,0,0,2,8,0],
 *  [0,0,0,4,1,9,0,0,5],
 *  [0,0,0,0,8,0,0,7,9]
 * ]
 *
 * Due to the number of records, I will describe the code instead of writing out each iteration.
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * During each iteration the row is checked, if any entries are duplicated, the board is invalid.  In this case each row
 * is free of duplicates, this check passes.
 *
 * <<< FOR LOOP TERMINATED: $i = count($board) >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * During each iteration the column is checked, if any entries are duplicated, the board is invalid.  In this case each
 * column is free of duplicates, this check passes.
 *
 * <<< FOR LOOP TERMINATED: $j = count($board) >>>
 *
 * $regionSize = 3
 * <<< FOR LOOP BEGIN >>>
 *  <<< FOR LOOP BEGIN >>>
 *
 *  During each iteration the 3 x 3 sub-grid is checked, if any entries are duplicated, the board is invalid.  In this
 *  case each sub-grid is free of duplicates, this check passes
 *
 *  <<< FOR LOOP TERMINATED: $l = $regionSize >>>
 * <<< FOR LOOP TERMINATED: $k = $regionSize >>>
 *
 * return true
 *
 * @param array $board
 * @return bool
 * @throws \InvalidArgumentException
 */
function checkSudokuBoard(array $board)
{
    if (empty($board)) {
        throw new \InvalidArgumentException('The $board cannot be empty');
    }

    // Check the rows
    for ($i = 0; $i < count($board); $i++) {
        if (hasDuplicate($board, $i, $i + 1, 0, count($board), count($board))) {
            return false;
        }
    }

    // Check the columns
    for ($j = 0; $j < count($board); $j++) {
        if (hasDuplicate($board, 0, count($board), $j, $j + 1, count($board))) {
            return false;
        }
    }

    // Check the sub-grids
    $regionSize = (int) sqrt(count($board));
    for ($k = 0; $k < $regionSize; $k++) {
        for ($l = 0; $l < $regionSize; $l++) {
            if (hasDuplicate($board, $regionSize * $k, $regionSize * ($k + 1), $regionSize * $l, $regionSize * ($l + 1), count($board))) {
                return false;
            }
        }
    }

    return true;
}

/**
 * Determine if a Sudoku board has a duplicate element in the range [1, $numberOfElements]
 *
 * @param array $board
 * @param int $startRow
 * @param int $endRow
 * @param int $startCol
 * @param int $endCol
 * @param int $numberOfElements
 * @return bool
 */
function hasDuplicate($board, $startRow, $endRow, $startCol, $endCol, $numberOfElements)
{
    $isPresent = array_fill(1, $numberOfElements + 1, false);

    for ($i = $startRow; $i < $endRow; $i++) {
        for ($j = $startCol; $j < $endCol; $j++) {
            if ($board[$i][$j] !== 0 && $isPresent[$board[$i][$j]]) {
                return true;
            }

            $isPresent[$board[$i][$j]] = true;
        }
    }

    return false;
}

$inputHelper = new InputHelper();
$board = json_decode($inputHelper->readInputFromStdIn('Enter the 2D array representing the Sudoku board in json format: '));
$result = checkSudokuBoard($board);

if ($result) {
    printf('The Sudoku board %s is valid.', json_encode($board));
} else {
    printf('The Sudoku board %s is not valid.', json_encode($board));
}