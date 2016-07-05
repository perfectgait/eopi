<?php

require_once '../autoload.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(2^n)
 */

const PEG_COUNT = 3;

/**
 * Iteratively print the steps required to solve the tower of hanoi puzzle.  This works by following a pattern which
 * results in the correct output.  The number of moves is always 2^n - 1 so we know how many iterations the while loop
 * has to run.  At each iteration we apply the pattern to find the correct move and print the result.  The patterns are
 * as follows.
 * If the number of rings is odd:
 * 1. Make correct move between peg 0 and peg 2
 * 2. Make correct move between peg 0 and peg 1
 * 3. Make correct move between peg 2 and peg 1
 * 4. Repeat
 *
 * If the number of rings is even:
 * 1. Make the correct move between peg 0 and peg 1
 * 2. Make the correct move between peg 0 and peg 2
 * 3. Make the correct move between peg 1 and peg 2
 * 4. Repeat
 *
 * The wikipedia page discusses the pattern in more detail.
 *
 * i.e.
 * If the number of rings is 3
 *
 * $pegs = [
 *  [
 *      0 => 3,
 *      1 => 2,
 *      2 => 3
 *  ],
 *  [],
 *  []
 * ]
 * $i = 1
 * $auxiliary = 2
 * $destination = 1
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i % 3 == 1
 * Is $pegs[2] empty or $pegs[0]->top() < $pegs[2]->top()? Yes
 * $from = 0
 * $to = 2
 * Move is from peg 0 to peg 2
 * $pegs = [
 *  [
 *      0 => 3,
 *      1 => 2
 *  ],
 *  [],
 *  [
 *      0 => 1
 *  ]
 * ]
 *
 * Iteration 2:
 * $i % 3 = 2
 * Is $pegs[1] empty or $pegs[0]->top() < $pegs[1]->top()? Yes
 * $from = 0
 * $to = 1
 * Move is from peg 0 to 1
 * $pegs = [
 *  [
 *      0 => 3
 *  ],
 *  [
 *      0 => 2
 *  ],
 *  [
 *      0 => 1
 *  ]
 * ]
 *
 * Iteration 3:
 * $i % 3 = 0
 * Is $pegs[2] empty or $pegs[1]->top() < $pegs[2]->top()? No
 * $from = 2
 * $to = 1
 * Move is from peg 2 to peg 1
 * $pegs = [
 *  [
 *      0 => 3
 *  ],
 *  [
 *      0 => 2,
 *      1 => 1
 *  ],
 *  []
 * ]
 *
 * Iteration 4:
 * $i %3 = 1
 * Is $pegs[2] empty or $pegs[0]->top() < $pegs[2]->top()? Yes
 * $from = 0
 * $to = 2
 * Move is from peg 0 to peg 2
 * $pegs = [
 *  [],
 *  [
 *      0 => 2,
 *      1 => 1
 *  ],
 *  [
 *      0 => 3
 *  ]
 * ]
 *
 * Iteration 5:
 * $i % 3 = 2
 * Is $pegs[1] empty or $pegs[0]->top() < $pegs[1]->top()? No
 * $from = 1
 * $to = 0
 * Move is from peg 1 to peg 0
 * $pegs = [
 *  [
 *      0 => 1
 *  ],
 *  [
 *      0 => 2
 *  ],
 *  [
 *      0 => 3
 *  ]
 * ]
 *
 * Iteration 6:
 * $i % 3 = 0
 * Is $pegs[2] empty or $pegs[1]->top() < $pegs[2]->top()? Yes
 * $from = 1
 * $to = 2
 * Move is from peg 1 to peg 2
 * $pegs = [
 *  [
 *      0 => 1
 *  ],
 *  [],
 *  [
 *      0 => 3,
 *      1 => 2
 *  ]
 * ]
 *
 * Iteration 7:
 * $i % 3 = 1
 * Is $pegs[2] empty or $pegs[0]->top() < $pegs[2]->top()? Yes
 * $from = 0
 * $to = 2
 * Move is from peg 0 to peg 2
 * $pegs = [
 *  [],
 *  [],
 *  [
 *      0 => 3,
 *      1 => 2,
 *      2 => 1
 *  ]
 * ]
 *
 * <<< WHILE LOOP TERMINATION: $i = 2^n - 1 >>>
 *
 * The moves are:
 * #1 - from peg 0 to peg 2
 * #2 - from peg 0 to 1
 * #3 - from peg 2 to peg 1
 * #4 - from peg 0 to peg 2
 * #5 - from peg 1 to peg 0
 * #6 - from peg 1 to peg 2
 * #7 - from peg 0 to peg 2
 *
 * @param int $numberOfRings
 * @throws \InvalidArgumentException
 * @see https://en.wikipedia.org/wiki/Tower_of_Hanoi
 */
function printTowerOfHanoiSteps($numberOfRings)
{
    if ($numberOfRings <= 0) {
        throw new \InvalidArgumentException('$numberOfRings must be > 0');
    }

    $pegs = [];

    for ($i = 0; $i < PEG_COUNT; $i++) {
        $pegs[$i] = new \SplStack();

        if ($i == 0) {
            for ($j = $numberOfRings; $j > 0; $j--) {
                $pegs[$i]->push($j);
            }
        }
    }

    $i = 1;
    $auxiliary = 1;
    $destination = 2;

    if (($numberOfRings % 2) != 0) {
        $auxiliary = 2;
        $destination = 1;
    }

    while ($i <= pow(2, $numberOfRings) - 1) {
        $from = null;
        $to = null;

        if ($i % PEG_COUNT == 1) {
            // Either move from peg 0 to peg $auxiliary or peg $auxiliary to peg 0
            if ($pegs[$auxiliary]->isEmpty() || (!$pegs[0]->isEmpty() && ($pegs[0]->top() < $pegs[$auxiliary]->top()))) {
                $from = 0;
                $to = $auxiliary;
            } else {
                $from = $auxiliary;
                $to = 0;
            }
        } elseif ($i % PEG_COUNT == 2) {
            // Either move from peg 0 to peg $destination or peg $destination to peg 0
            if ($pegs[$destination]->isEmpty() || (!$pegs[0]->isEmpty() && ($pegs[0]->top() < $pegs[$destination]->top()))) {
                $from = 0;
                $to = $destination;
            } else {
                $from = $destination;
                $to = 0;
            }
        } else {
            // Either move from peg $destination to peg $auxiliary or peg $auxiliary to peg $destination
            if ($pegs[$auxiliary]->isEmpty() || (!$pegs[$destination]->isEmpty() && ($pegs[$destination]->top() < $pegs[$auxiliary]->top()))) {
                $from = $destination;
                $to = $auxiliary;
            } else {
                $from = $auxiliary;
                $to = $destination;
            }
        }

        $pegs[$to]->push($pegs[$from]->pop());

        printf('Move #%d: from peg %d to peg %d', $i, $from, $to);
        print PHP_EOL;

        $i++;
    }
}

$inputHelper = new InputHelper();
$numberOfRings = (int)$inputHelper->readInputFromStdIn('Enter the number of rings to move: ');
printTowerOfHanoiSteps($numberOfRings);