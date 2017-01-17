<?php

require_once '../bootstrap.php';

use EOPI\DataStructures\ListNode;
use EOPI\Factory\LinkedListFactory;
use EOPI\Factory\NodeFactory;

/**
 * The time complexity is O(F) + O(C) where F is the number of nodes to the start of the cycle and C is the number of
 * nodes in the cycle, and the space complexity is O(1).
 */

/**
 * Calculate the start of a cycle in a singly linked list.
 * This works by first checking to see if a cycle can be found.  To do this it creates one fast iterator and one slow
 * iterator.  The fast iterator iterates by 2 while the slow iterator iterates by 1.  If a cycle exists, the two
 * iterators will eventually meet because they will both enter the cycle.  Since they are not iterating in tandem they
 * will eventually overlap.  Either the fast iterator will land on the slow iterator or one ahead of it in which case
 * the slow iterator will equal the fast iterator when it advances next.
 *
 * If a cycle is found it then determines the length of the cycle so that the start of the cycle can be found.  Since
 * both iterators are at the same point now we can simply advance one until it reaches the other, counting along the
 * way.  When both iterators meet each other again, the cycle length has been found.
 *
 * Finally we use the cycle length to calculate the beginning of the cycle.  To do this, both iterators are set back to
 * the head.  Then one of the iterators is advanced cycle count number of times until it is cycle count ahead of the
 * other iterator.  Then both iterators are advanced in tandem until they meet each other.  When they meet, the start of
 * the cycle has been found.  This is true because by advancing the first iterator forward first, it will have entered
 * the cycle exactly as the second iterator has.
 *
 * i.e.
 * If the $head is 0 and the list overall is 0->1->2->3->4 5->6
 *                                              ^        |
 *                                              |________|
 *
 * $fastIterator = 0
 * $slowIterator = 0
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $slowIterator = 1
 * $fastIterator = 2
 * Is $fastIterator == $slowIterator? No
 *
 * Iteration 2:
 * $slowIterator = 2
 * $fastIterator = 4
 * Is $fastIterator == $slowIterator? No
 *
 * Iteration 3:
 * $slowIterator = 3
 * $fastIterator = 2
 * Is $fastIterator == $slowIterator? No
 *
 * Iteration 4:
 * $slowIterator = 4
 * $fastIterator = 4
 * Is $fastIterator == $slowIterator? Yes
 * $cycleLength = 0
 *
 *      <<< DO/WHILE LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $cycleLength = 1
 *      $slowIterator = 1
 *      Is $fastIterator == $slowIterator? No
 *
 *      Iteration 2:
 *      $cycleLength = 2
 *      $slowIterator = 2
 *      Is $fastIterator == $slowIterator? No
 *
 *      Iteration 3:
 *      $cycleLength = 3
 *      $slowIterator = 3
 *      Is $fastIterator == $slowIterator? No
 *
 *      Iteration 4:
 *      $cycleLength = 4
 *      $slowIterator = 4
 *      Is $fastIterator == $slowIterator? Yes
 *
 *      $fastIterator = 0
 *      $slowIterator = 0
 *
 *          <<< WHILE LOOP BEGIN >>>
 *
 *          Iteration 1:
 *          $cycleLength = 4
 *          $fastIterator = 1
 *
 *          Iteration 2:
 *          $cycleLength = 3
 *          $fastIterator = 2
 *
 *          Iteration 3:
 *          $cycleLength = 2
 *          $fastIterator = 3
 *
 *          Iteration 4:
 *          $cycleLength = 1
 *          $fastIterator = 4
 *
 *          Iteration 5:
 *          $cycleLength = 0
 *          $fastIterator = 1
 *
 *          <<< WHILE LOOP TERMINATION: $cycleLength = -1 >>>
 *
 *          <<< WHILE LOOP BEGIN >>>
 *
 *          Iteration 1:
 *          $slowIterator = 1
 *          $fastIterator = 1
 *          Is $slowIterator == $fastIterator? Yes
 *          Return $slowIterator
 *
 *          <<< WHILE LOOP TERMINATION: $slowIterator == $fastIterator >>>
 *
 *      <<< DO/WHILE LOOP TERMINATION: $slowIterator == $fastIterator >>>
 *
 * <<< WHILE LOOP TERMINATION: cycle head returned >>>
 *
 * Returned value is node 1
 *
 * @param ListNode $head
 * @return ListNode|null
 */
function calculateCycleStart(ListNode $head)
{
    $fastIterator = $head;
    $slowIterator = $head;

    while ($fastIterator && $fastIterator->next && $fastIterator->next->next) {
        $slowIterator = $slowIterator->next;
        $fastIterator = $fastIterator->next->next;

        // Cycle found
        if ($fastIterator == $slowIterator) {
            // Determine the cycle length
            $cycleLength = 0;

            do {
                $cycleLength++;
                $slowIterator = $slowIterator->next;
            } while ($slowIterator != $fastIterator);

            // Determine cycle start
            $fastIterator = $head;
            $slowIterator = $head;

            // Advance one of the iterators ahead the cycle length
            while ($cycleLength--) {
                $fastIterator = $fastIterator->next;
            }

            // Advancing both iterators at the same pace will yield the start of the cycle when they are equal because
            // one of them is $cycleLength ahead of the other.  When the iterator that is $cycleLength ahead reaches the
            // cycle, it will be at the same point as the other iterator and the start of the cycle will be found.
            while ($slowIterator != $fastIterator) {
                $slowIterator = $slowIterator->next;
                $fastIterator = $fastIterator->next;
            }

            return $slowIterator;
        }
    }

    // No cycle found
    return null;
}

$nodes = [];

for ($i = 9; $i >= 0; $i--) {
    $nodes[$i] = NodeFactory::makeListNode($i, isset($nodes[$i + 1]) ? $nodes[$i + 1] : null);
}

$nodes[8]->next = $nodes[4];
$linkedList = LinkedListFactory::makeSinglyLinkedListFromHead($nodes[0]);
$cycleStart = calculateCycleStart($linkedList->head);

if ($cycleStart) {
    print 'A cycle was found: ' . PHP_EOL;
    var_dump($cycleStart);
} else {
    print 'No cycle was found' . PHP_EOL;
}

$nodes = [];

for ($i = 9; $i >= 0; $i--) {
    $nodes[$i] = NodeFactory::makeListNode($i, isset($nodes[$i + 1]) ? $nodes[$i + 1] : null);
}

$linkedList = LinkedListFactory::makeSinglyLinkedListFromHead($nodes[0]);
$cycleStart = calculateCycleStart($linkedList->head);

if ($cycleStart) {
    print 'A cycle was found: ' . PHP_EOL;
    var_dump($cycleStart);
} else {
    print 'No cycle was found' . PHP_EOL;
}