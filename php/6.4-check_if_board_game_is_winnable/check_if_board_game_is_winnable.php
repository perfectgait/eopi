<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array
 */

/**
 * Check if a board game is winnable.  This works by going through each index in the board and determining the maximum
 * move that can be made.  The maximum move is the current index + the number at that position in the board (i.e. if
 * the current index is 1 and the number at position 1 is 5 the maximum move is 6).  The loop stops if the current index
 * is greater than the furthest reach found or there are no more indexes.  If the current index is greater than the
 * furthest reach found that means that spot in the board cannot be reached.  If the board is [2, 0, 0, 1] the loop
 * would stop at index 3.  The player could advance from index 0 to index 2 but that is as far as they could get.  Once
 * we reach index 3 we realize that the game is over because we could not advance to index 3 at any point.
 *
 * i.e.
 *
 * If the board is [3,3,1,0,2,0,1]
 *
 * $furthestReach = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * $board[0] = 3
 * $furthestReach = 3
 *
 * Iteration 2:
 * $i = 1
 * $board[1] = 3
 * $furthestReach = 4
 *
 * Iteration 3:
 * $i = 2
 * $board[2] = 1
 * $furthestReach = 4
 *
 * Iteration 4:
 * $i = 3
 * $board[3] = 0
 * $furthestReach = 4
 *
 * Iteration 5:
 * $i = 4
 * $board[4] = 2
 * $furthestReach = 6
 *
 * <<< LOOP TERMINATION: $furthestReach (6) is not < count($board) - 1 >>>
 *
 * Game is winnable
 *
 * ===============================================================
 *
 * If the board is [3,2,0,0,2,0,1]
 *
 * $furthestReach = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * $board[0] = 3
 * $furthestReach = 3
 *
 * Iteration 2:
 * $i = 1
 * $board[1] = 2
 * $furthestReach = 3
 *
 * Iteration 3:
 * $i = 2
 * $board[2] = 0
 * $furthestReach = 3
 *
 * Iteration 4:
 * $i = 3
 * $board[3] = 0
 * $furthestReach = 3
 *
 * <<< LOOP TERMINATION: $i (4) is not <= $furthestReach (3) >>>
 *
 * Game is not winnable
 *
 * @param array $board
 * @return bool
 */
function checkWinnable(array $board)
{
    $furthestReach = 0;

    for ($i = 0; $i <= $furthestReach && $furthestReach < count($board) - 1; $i++) {
        print $i . PHP_EOL;
        $furthestReach = max($furthestReach, $i + $board[$i]);
    }

    return $furthestReach >= count($board) - 1;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the board as an array in json format: '));
$result = checkWinnable($array);

if ($result) {
    printf('The board %s is winnable', json_encode($array));
} else {
    printf('The board %s is not winnable', json_encode($array));
}

print PHP_EOL;