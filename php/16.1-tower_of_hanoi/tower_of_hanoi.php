<?php

require_once '../autoload.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(2^n)
 */

const PEG_COUNT = 3;

/**
 * Compute the moves required to transfer all rings from the first peg to the second using the third as an intermediary.
 *
 * @param int $numberOfRings
 * @throws \InvalidArgumentException
 */
function computeTowerOfHanoiMoves($numberOfRings)
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

    printTowerOfHanoiSteps($numberOfRings, $pegs, 0, 1, 2);
}

/**
 * Recursively print the steps required to move all rings to the destination maintaining the invariant that no larger
 * ring can ever be on top of a smaller ring.  The thing to remember here is that the first step is to get all rings
 * except the largest one to the last peg first, using the middle peg.  The second step is to transfer the largest ring
 * from the first peg to the middle peg.  The final step is to transfer all of the rings, except the largest, to the
 * middle peg, using the first peg.  The recursion may seem daunting but focusing on those three steps makes this
 * problem pretty straightforward.  You don't have to understand how everything is being handled recursively.  If you
 * understand and handle the outer conditions properly, the rest will take care of itself.
 * This works by first recursively moving all rings from peg 0 to peg 2 using peg 1 as an intermediary.  Then it
 * recursively moves all rings from peg 2 to peg 1 using peg 0 as an intermediary.  It will be easier to see what is
 * happening in the example.
 *
 * i.e.
 * If the starting number of rings is 3, from peg is 0, to peg is 1 and use peg is 2.
 *
 * $numberOfRings = 3
 * $pegs = [
 *  [
 *      0 => 3,
 *      1 => 2,
 *      2 => 1
 *  ],
 *  [],
 *  [],
 * ]
 * $fromPeg = 0
 * $toPeg = 1
 * $usePeg = 2
 *
 * Is the $numberOfRings > 0? Yes
 *      <<< FIRST RECURSIVE CALL BEGIN >>>
 *      $numberOfRings = 2
 *      $fromPeg = 0
 *      $toPeg = 2
 *      $usePeg = 1
 *
 *      Is the $numberOfRings > 0? Yes
 *          <<< FIRST RECURSIVE CALL BEGIN >>>
 *          $numberOfRings = 1
 *          $fromPeg = 0
 *          $toPeg = 1
 *          $usePeg = 2
 *
 *          Is the $numberOfRings > 0? Yes
 *              <<< FIRST RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 0
 *              $toPeg = 2
 *              $usePeg = 1
 *
 *              Is the $numberOfRings > 0? No
 *              <<< FIRST RECURSIVE CALL RETURN >>>
 *
 *          Move ring from peg 0 to peg 1
 *          $pegs = [
 *              [
 *                  0 => 3,
 *                  1 => 2
 *              ],
 *              [
 *                  0 => 1
 *              ],
 *              []
 *          ]
 *
 *              <<< SECOND RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 2
 *              $toPeg = 1
 *              $usePeg = 0
 *
 *              Is $numberOfRings > 0? No
 *              <<< SECOND RECURSIVE CALL RETURN >>>
 *          <<< FIRST RECURSIVE CALL RETURN >>>
 *
 *      Move ring from peg 0 to peg 2
 *      $pegs = [
 *          [
 *              0 => 3
 *          ],
 *          [
 *              0 => 1
 *          ],
 *          [
 *              0 => 2
 *          ]
 *      ]
 *
 *          <<< SECOND RECURSIVE CALL BEGIN >>>
 *          $numberOfRings = 1
 *          $fromPeg = 1
 *          $toPeg = 2
 *          $usePeg = 0
 *
 *          Is $numberOfRings > 0? Yes
 *              <<< FIRST RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 1
 *              $toPeg = 0
 *              $usePeg = 2
 *
 *              Is $numberOfRings > 0? No
 *              <<< FIRST RECURSIVE CALL RETURN >>>
 *
 *          Move ring from peg 1 to peg 2
 *          $pegs = [
 *              [
 *                  0 => 3
 *              ],
 *              [],
 *              [
 *                  0 => 2,
 *                  1 => 1
 *              ]
 *          ]
 *
 *              <<< SECOND RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 0
 *              $toPeg = 2
 *              $usePeg = 1
 *
 *              Is $numberOfRings > 0? No
 *              <<< SECOND RECURSIVE CALL RETURN >>>
 *          <<< SECOND RECURSIVE CALL RETURN >>>
 *      <<< FIRST RECURSIVE CALL RETURN >>>
 *
 * Move ring from peg 0 to peg 1
 * $pegs = [
 *      [],
 *      [
 *          0 => 3
 *      ],
 *      [
 *          0 => 2,
 *          1 => 1
 *      ]
 * ]
 *
 *      <<< SECOND RECURSIVE CALL BEGIN >>>
 *      $numberOfRings = 2
 *      $fromPeg = 2
 *      $toPeg = 1
 *      $usePeg = 0
 *
 *      Is $numberOfRings > 0? Yes
 *          <<< FIRST RECURSIVE CALL BEGIN >>>
 *          $numberOfRings = 1
 *          $fromPeg = 2
 *          $toPeg = 0
 *          $usePeg = 1
 *
 *          Is $numberOfRings > 0? Yes
 *              <<< FIRST RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 2
 *              $toPeg = 1
 *              $usePeg = 0
 *
 *              Is $numberOfRings > 0? No
 *              <<< FIRST RECURSIVE CALL RETURN
 *
 *          Move ring from peg 2 to peg 0
 *          $pegs = [
 *              [
 *                  0 => 1
 *              ],
 *              [
 *                  0 => 3
 *              ],
 *              [
 *                  0 => 2
 *              ]
 *          ]
 *
 *              <<< SECOND RECURSIVE CALL END >>>
 *              $numberOfRings = 0
 *              $fromPeg = 1
 *              $toPeg = 0
 *              $usePeg = 2
 *
 *              Is $numberOfRings > 0? No
 *              <<< SECOND RECURSIVE CALL RETURN >>>
 *          <<< FIRST RECURSIVE CALL RETURN >>>
 *
 *      Move ring from peg 2 to peg 1
 *      $pegs = [
 *          [
 *              0 => 1
 *          ],
 *          [
 *              0 => 3,
 *              1 => 2
 *          ],
 *          []
 *      ]
 *
 *          <<< SECOND RECURSIVE CALL BEGIN >>>
 *          $numberOfRings = 1
 *          $fromPeg = 0
 *          $toPeg = 1
 *          $usePeg = 2
 *
 *          Is $numberOfRings > 0? Yes
 *              <<< FIRST RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 0
 *              $toPeg = 2
 *              $usePeg = 1
 *
 *              Is $numberOfRings > 0? No
 *              <<< FIRST RECURSIVE CALL RETURN >>>
 *
 *          Move ring from peg 0 to peg 1
 *          $pegs = [
 *              [],
 *              [
 *                  0 => 3,
 *                  1 => 2,
 *                  2 => 1
 *              ],
 *              []
 *          ]
 *
 *              <<< SECOND RECURSIVE CALL BEGIN >>>
 *              $numberOfRings = 0
 *              $fromPeg = 2
 *              $toPeg = 1
 *              $usePeg = 0
 *
 *              Is $numberOfRings > 0? No
 *              <<< SECOND RECURSIVE CALL RETURN >>>
 *          <<< SECOND RECURSIVE CALL RETURN >>>
 *      <<< SECOND RECURSIVE CALL RETURN >>>
 *
 * @param int $numberOfRings
 * @param array[\SplStack] $pegs
 * @param int $fromPeg
 * @param int $toPeg
 * @param int $usePeg
 */
function printTowerOfHanoiSteps($numberOfRings, $pegs, $fromPeg, $toPeg, $usePeg)
{
    if ($numberOfRings > 0) {
        printTowerOfHanoiSteps($numberOfRings - 1, $pegs, $fromPeg, $usePeg, $toPeg);

        printf('Move %d from peg %d to peg %d', $pegs[$fromPeg]->top(), $fromPeg, $toPeg);
        print PHP_EOL;
        $pegs[$toPeg]->push($pegs[$fromPeg]->top());
        $pegs[$fromPeg]->pop();

        printTowerOfHanoiSteps($numberOfRings - 1, $pegs, $usePeg, $toPeg, $fromPeg);
    }
}

$inputHelper = new InputHelper();
$numberOfRings = (int)$inputHelper->readInputFromStdIn('Enter the number of rings to move: ');
computeTowerOfHanoiMoves($numberOfRings);