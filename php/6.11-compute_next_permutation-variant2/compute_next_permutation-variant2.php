<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(1)
 */

/**
 * Get the previous permutation.  This works by first finding the longest increasing sequence of elements starting from
 * the end of the permutation array.
 *
 * If the longest increasing sequence is the entire array then there is no next permutation, we were given the first
 * one.
 *
 * If the longest increasing sequence is not the entire array, remember the element just before the increasing sequence
 * in $i.  Then go through $permutation[$i + 1:count($permutation)] in reverse order and find the first element that is
 * less than $permutation[$i] and swap the two.  Because $permutation[$i + 1:count($permutation)] is in ascending
 * order the first element that is < is also the largest element in $permutation[$i + 1:count($permutation)] that is <.
 * It also means that when the swap is done, $permutation[$i + 1:count($permutation)] is still sorted in ascending
 * order.  For example if $i = 7 and $permutation[$i + 1:count($permutation)] = [5,8,9], 5 and 7 would be swapped
 * making $permutation[$i + 1:count($permutation)] = [7,8,9] which is still sorted in ascending order.  After the
 * swap is done, $permutation[$i + 1:count($permutation)] needs to be sorted in reverse order to create the largest
 * permutation which is the previous one.  So if $permutation[$i + 1:count($permutation)] = [5,8,9] it becomes [9,8,5]
 * because that is the largest possible dictionary ordering.
 *
 * i.e.
 * If the input array is [4,5,0,1,2,3,6]
 *
 * $i = 5
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is $i >= 0 and $permutation[$i](3) < $permutation[$i + 1](6)? Yes
 * $i = 4
 *
 * Iteration 2:
 * Is $i >= 0 and $permutation[$i](2) < $permutation[$i + 1](3)? Yes
 * $i = 3
 *
 * Iteration 3:
 * Is $i >= 0 and $permutation[$i](1) < $permutation[$i + 1](1)? Yes
 * $i = 1
 *
 * Iteration 4:
 * Is $i >= 0 and $permutation[$i](0) < $permutation[$i + 1](1)? Yes
 * $i = 1
 *
 * Iteration 5:
 * Is $i >= 0 and $permutation[$i](5) < $permutation[$i + 1](0)? No
 *
 * <<< WHILE LOOP TERMINATION: $permutation[$i] >= $permutation[$i + 1] >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 6
 * Is $permutation[$j](6) < $permutation[$i](5)? No
 *
 * Iteration 2:
 * $j = 5
 * Is $permutation[$j](3) < $permutation[$i](5)? Yes
 * $temp = 5
 * $permutation = [4,3,0,1,2,5,6]
 *
 * <<< FOR LOOP TERMINATION: break encountered >>>
 *
 * The sequence [0,1,2,5,6] in [4,3,0,1,2,5,6] is now reversed
 *
 * $permutation = [4,3,6,5,2,1,0]
 *
 * @param array $permutation
 * @return array
 */
function getPreviousPermutation(array $permutation)
{
    if (empty($permutation)) {
        throw new \InvalidArgumentException('$permutation may not be empty');
    }

    if (count($permutation) === 1) {
        return $permutation;
    }

    $i = count($permutation) - 2;

    while ($i >= 0 && $permutation[$i] < $permutation[$i + 1]) {
        $i--;
    }

    // This is already the minimum permutation
    if ($i === -1) {
        return $permutation;
    }

    // Find the largest entry in $permutation[$i + 1:count($permutation) - 1] that is less than $permutation[$i] and
    // swap the two.  We know that $permutation[$i + 1:count($permutation) - 1] is sorted in ascending order so the
    // first element we find in $permutation[$i + 1:count($permutation) - 1] that is greater than $permutation[$i] is
    // the element we want to swap with.
    for ($j = count($permutation) - 1; $j > $i; $j--) {
        if ($permutation[$j] < $permutation[$i]) {
            $temp = $permutation[$i];
            $permutation[$i] = $permutation[$j];
            $permutation[$j] = $temp;

            break;
        }
    }

    // Now $permutation[$i + 1:count($permutation) - 1] is reversed so that it's sorted in descending order.  This
    // represents the largest permutation in dictionary ordering prior to the one we are given.
    array_splice($permutation, $i + 1, count($permutation) - $i + 1, array_reverse(array_slice($permutation, $i + 1)));

    return $permutation;
}

$inputHelper = new InputHelper();
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the permutation in json format: '));
$result = getPreviousPermutation($permutation);

printf(
    'The previous permutation before %s is %s',
    json_encode($permutation),
    json_encode($result)
);
print PHP_EOL;