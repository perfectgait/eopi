<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array
 */

/**
 * Return the number of moves it takes to win a board game or false if it cannot be won.  This works by going through
 * each index in the board and determining the maximum move that can be made.  The maximum move is the current index +
 * the number at that position in the board (i.e. if the current index is 1 and the number at position 1 is 5 the
 * maximum move is 6).  If maximum move is greater than the current furthest reach, the number of moves is incremented
 * by 1 because that is a move we want to make.  At the end of the loop if the furthest reach is less than the size of
 * the board the game is un-winnable.  If not, the game is winnable and the number of moves needed to win is returned.
 *
 * i.e.
 *
 * If the board is [3,3,1,0,2,0,1]
 *
 * $furthestReach = 0
 * $moves = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * is $i(0) + $board[$i](3) > $furthestReach(0)?, YES
 * $moves = 1
 * $furthestReach = 3
 *
 * Iteration 2:
 * $i = 1
 * is $i(1) + $board[$i](3) > $furthestReach(3)?, YES
 * $moves = 2
 * $furthestReach = 4
 *
 * Iteration 3:
 * $i = 2
 * is $i(2) + $board[$i](1) > $furthestReach(4)?, NO
 * $moves = 2
 * $furthestReach = 4
 *
 * Iteration 4:
 * $i = 3
 * is $i(3) + $board[$i](0) > $furthestReach(4)?, NO
 * $moves = 2
 * $furthestReach = 4
 *
 * Iteration 5:
 * $i = 4
 * is $i(4) + $board[$i](2) > $furthestReach(4)?, YES
 * $moves = 3
 * $furthestReach = 6
 *
 * <<< LOOP TERMINATION: $furthestReach (6) is not < count($board) - 1 >>>
 *
 * Game is winnable in 3 moves
 *
 * ===============================================================
 *
 * If the board is [100,3,1,0,2,0,1]
 *
 * $furthestReach = 0
 * $moves = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * is $i(0) + $board[$i](100) > $furthestReach(0)?, YES
 * $moves = 1
 * $furthestReach = 100
 *
 * Iteration 2:
 * $i = 1
 * is $i(1) + $board[$i](3) > $furthestReach(100)?, NO
 * $moves = 1
 * $furthestReach = 100
 *
 * Iteration 3:
 * $i = 2
 * is $i(2) + $board[$i](1) > $furthestReach(100)?, NO
 * $moves = 1
 * $furthestReach = 100
 *
 * Iteration 4:
 * $i = 3
 * is $i(3) + $board[$i](0) > $furthestReach(100)?, NO
 * $moves = 1
 * $furthestReach = 100
 *
 * Iteration 5:
 * $i = 4
 * is $i(4) + $board[$i](2) > $furthestReach(100)?, NO
 * $moves = 1
 * $furthestReach = 100
 *
 * <<< LOOP TERMINATION: $furthestReach (6) is not < count($board) - 1 >>>
 *
 * Game is winnable in 1 move
 *
 * @param array $board
 * @return int|bool
 */
function getNumberOfMovesToWin(array $board)
{
    $furthestReach = 0;
    $moves = 0;

    for ($i = 0; $i <= $furthestReach && $furthestReach < count($board) - 1; $i++) {
        if ($i + $board[$i] > $furthestReach) {
            $moves++;
            $furthestReach = $i + $board[$i];
        }
    }

    if ($furthestReach < count($board) - 1) {
        return false;
    }

    return $moves;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the board as an array in json format: '));
$result = getNumberOfMovesToWin($array);

if ($result) {
    printf('The board %s can be won in %d move(s)', json_encode($array), $result);
} else {
    printf('The board %s is not winnable', json_encode($array));
}

print PHP_EOL;