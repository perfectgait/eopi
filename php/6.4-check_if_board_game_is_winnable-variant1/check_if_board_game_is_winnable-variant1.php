<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the board.  If every entry in the board is added as a move it
 * can only be replaced once.  At most the function will go through the board once and remove every entry once.
 *
 * The storage complexity is O(n).  If every entry in the board points to the next the maximum size of the stack becomes
 * the size of the board.
 */

/**
 * Return the number of moves it takes to win a board game or false if it cannot be won.  This works by first adding the
 * last element in the board to the stack of moves.  Then the function traverses the board in reverse order and at each
 * iteration, pops all elements off the moves stack that is less efficient than the current move.  After all inefficient
 * moves have been popped off, the last move and the current move are added to the stack.
 *
 * i.e.
 *
 * If the board is [3,3,1,0,2,0,1]
 *
 * $moves = [6]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 5
 * $i(5) + $board[$i](0) is not >= any moves, nothing happens
 * $moves = [6]
 *
 * Iteration 2:
 * $i = 4
 * $i(4) + $board[$i](2) is >= than the only move in the stack
 * $lastMove = 6
 * $moves = [6, 4]
 *
 * Iteration 3:
 * $i = 3
 * $i(3) + $board[$i](0) is not >= any moves, nothing happens
 * $moves = [6, 4]
 *
 * Iteration 4:
 * $i = 2
 * $i(2) + $board[$i](1) is not >= any moves, nothing happens
 * $moves = [6, 4]
 *
 * Iteration 5:
 * $i = 1
 * $i(1) + $board[$i](3) is >= than the top move in the stack
 * $lastMove = 4
 * $moves = [6, 4, 1]
 *
 * Iteration 6:
 * $i = 0
 * $i(0) + $board[$i](3) is >= than the top move in the stack
 * $lastMove = 1
 * $moves = [6, 4, 1, 0]
 *
 * <<< LOOP TERMINATION: $i < 0 >>>
 *
 * Popping the stack until it's empty yields the sequence 0-->1-->4-->6
 *
 * ===============================================================
 *
 * If the board is [100,2,0,0,2,0,1]
 *
 * $moves = [6]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 5
 * $i(5) + $board[$i](0) is not >= any moves, nothing happens
 * $moves = [6]
 *
 * Iteration 2:
 * $i = 4
 * $i(4) + $board[$i](2) is >= the only move in the stack
 * $lastMove = 6
 * $moves = [6, 4]
 *
 * Iteration 3:
 * $i = 3
 * $i(3) + $board[$i](0) is not >= any moves, nothing happens
 * $moves = [6, 4]
 *
 * Iteration 4:
 * $i = 2
 * $i(2) + $board[$i](0) is not >= any moves, nothing happens
 * $moves = [6, 4]
 *
 * Iteration 5:
 * $i = 1
 * $i(1) + $board[$i](2) is not >= any moves, nothing happens
 * $moves = [6, 4]
 *
 * Iteration 6:
 * $i = 0
 * $i(0) + $board[$i](100) is >= than every move in the stack
 * $lastMove = 6
 * $moves = [6, 0]
 *
 * <<< LOOP TERMINATION: $i < 0 >>>
 *
 * Popping the stack until it's empty yields the sequence 0-->6
 *
 * @param array $board
 * @return \SplStack
 */
function getNumberOfMovesToWin(array $board)
{
    $moves = new \SplStack();
    $moves->push(count($board) - 1);

    for ($i = count($board) - 2; $i >= 0; $i--) {
        $lastMove = null;

        while (!$moves->isEmpty() && $i + $board[$i] >= $moves->top()) {
            $lastMove = $moves->pop();
        }

        if ($lastMove) {
            $moves->push($lastMove);
            $moves->push(min(count($board) - 1, $i));
        }
    }

    return $moves;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the board as an array in json format: '));
$result = getNumberOfMovesToWin($array);

// If the first move does not originate from the beginning of the board, the game cannot be won
if ($result->top() != 0) {
    printf('The board %s is not winnable', json_encode($array));
} else {
    $sequenceString = 'Sequence: ';
    // Remove one from the count for the last element which is always included
    $moveCount = $result->count() - 1;

    while (!$result->isEmpty()) {
        $sequenceString .= $result->pop();

        if (!$result->isEmpty()) {
            $sequenceString .= '-->';
        }
    }

    printf(
        'The board %s can be won in %d moves with the following sequence of indexes: %s',
        json_encode($array),
        $moveCount,
        $sequenceString
    );
}

print PHP_EOL;