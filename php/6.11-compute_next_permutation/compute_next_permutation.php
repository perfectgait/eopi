<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(1)
 */

/**
 * Get the next permutation.  This works by first finding the longest decreasing sequence of elements starting from the
 * end of the permutation array.
 *
 * If the longest decreasing sequence is the entire array then there is no next permutation, we were given the last one.
 *
 * If the longest decreasing sequence is not the entire array, remember the element just before the decreasing sequence
 * in $i.  Then go through $permutation[$i + 1:count($permutation)] in reverse order and find the first element that is
 * greater than $permutation[$i] and swap the two.  Because $permutation[$i + 1:count($permutation)] is in descending
 * order the first element that is > is also the smallest element in $permutation[$i + 1:count($permutation)] that is >.
 * It also means that when the swap is done, $permutation[$i + 1:count($permutation)] is still sorted in descending
 * order.  For example if $i = 6 and $permutation[$i + 1:count($permutation)] = [9,7,4,1], 7 and 6 would be swapped
 * making $permutation[$i + 1:count($permutation)] = [9,6,4,1] which is still sorted in descending order.  After the
 * swap is done, $permutation[$i + 1:count($permutation)] needs to be sorted in reverse order to create the smallest
 * permutation which is the next one.  So if $permutation[$i + 1:count($permutation)] = [9,6,4,1] it becomes [1,4,6,9]
 * because that is the smallest possible dictionary ordering.
 *
 * i.e.
 * If the input array is [6,2,1,5,4,3,0]
 *
 * $i = 5
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is $i >= 0 and $permutation[$i](3) > $permutation[$i + 1](0)? Yes
 * $i = 4
 *
 * Iteration 2:
 * Is $i >= 0 and $permutation[$i](4) > $permutation[$i + 1](3)? Yes
 * $i = 3
 *
 * Iteration 3:
 * Is $i >= 0 and $permutation[$i](5) > $permutation[$i + 1](4)? Yes
 * $i = 2
 *
 * Iteration 4:
 * Is $i >= 0 and $permutation[$i](1) > $permutation[$i + 1](5)? No
 *
 * <<< WHILE LOOP TERMINATION: $permutation[$i] <= $permutation[$i + 1] >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 6
 * is $permutation[$j](0) > $permutation[$i](1)? No
 *
 * Iteration 2:
 * $j = 5
 * is $permutation[$j](3) > $permutation[$i](1)? Yes
 * $temp = 1
 * $permutation = [6,2,3,5,4,1,0]
 *
 * <<< FOR LOOP TERMINATION: break encountered >>>
 *
 * The sequence [5,4,1,0] in [6,2,3,5,4,1,0] is now reversed
 *
 * $permutation = [6,2,3,0,1,4,5]
 *
 * @param array $permutation
 * @return array
 * @throws \InvalidArgumentException
 */
function getNextPermutation(array $permutation)
{
    if (empty($permutation)) {
        throw new \InvalidArgumentException('$permutation may not be empty');
    }

    if (count($permutation) === 1) {
        return $permutation;
    }

    $i = count($permutation) - 2;

    while ($i >= 0 && $permutation[$i] > $permutation[$i + 1]) {
        $i--;
    }

    // This is already the maximum permutation
    if ($i === -1) {
        return $permutation;
    }

    // Find the smallest entry in $permutation[$k + 1:count($permutation) - 1] that is larger than $permutation[$k] and
    // swap the two.  We know that $permutation[$k + 1:count($permutation) - 1] is sorted in descending order so the
    // first element we find in $permutation[$k + 1:count($permutation) - 1] that is greater than $permutation[$k] is
    // the element we want to swap with.
    for ($j = count($permutation) - 1; $j > $i; $j--) {
        if ($permutation[$j] > $permutation[$i]) {
            $temp = $permutation[$i];
            $permutation[$i] = $permutation[$j];
            $permutation[$j] = $temp;

            break;
        }
    }

    // Now $permutation[$k + 1:count($permutation) - 1] is reversed so that it's sorted in ascending order.
    array_splice($permutation, $i + 1, count($permutation) - $i + 1, array_reverse(array_slice($permutation, $i + 1)));

    return $permutation;
}

$inputHelper = new InputHelper();
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the permutation in json format: '));
$result = getNextPermutation($permutation);

printf(
    'The next permutation after %s is %s',
    json_encode($permutation),
    json_encode($result)
);
print PHP_EOL;