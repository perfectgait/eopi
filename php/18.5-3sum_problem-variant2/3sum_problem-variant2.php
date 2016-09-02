<?php

require_once '../autoload.php';

use \EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^k-1) and the space complexity is O(1)
 */

/**
 * Determine if an array can k-sum a number $t.  There are 3 cases which are handled.  When $k is 1 we just need to look
 * at the array and see if it contains the number $t.  If so, the array can 1-sum $t.  When $k is 2 we just need to look
 * at the array and see if it can 2-sum to $t.  When $k > 2 we use recursion to check and see if the array can k-sum to
 * $t.
 *
 * @param int[] $array
 * @param int $t
 * @param int $k
 * @return bool
 */
function hasKSum($array, $t, $k)
{
    if (empty($array)) {
        throw new \InvalidArgumentException('The input $array cannot be empty');
    }

    if ($t > PHP_INT_MAX || $t < (PHP_INT_MAX + 1) * -1) {
        throw new \InvalidArgumentException('$t must be between ' . ((PHP_INT_MAX + 1) * -1) . ' and ' . PHP_INT_MAX);
    }

    if ($k < 1 || $k > PHP_INT_MAX) {
        throw new \InvalidArgumentException('$k must be in the range 1 - ' . PHP_INT_MAX . ' inclusive');
    }

    sort($array);

    if ($k == 1) {
        // Simplest case where only the element $t has to exist in the array
        return in_array($t, $array);
    } elseif ($k == 2) {
        // Simple case where only two numbers in $array have to produce a sum of $t
        return hasTwoSum($array, $t);
    } else {
        // Complex case where recursion is required to determine if $k numbers produce a sum of $t
        return hasKSumRecursive($array, $t, $k);
    }
}

/**
 * Determine if an array can k-sum any of its elements to equal $t.  This works by iterating through each element of the
 * array and then looking at the value $k.  If $k is > 3 the function recursively calls itself, passing $t - $number as
 * the value to look for and $k - 1 as the number of elements needed for the sum.  Eventually the base case where $k = 2
 * is reached and then hasTwoSum is used to determine if two elements in the array can sum to the value of $t at the
 * time.  The boolean value is then returned back up the stack to get the result.  Obviously at very large values for $k
 * this is time consuming because recursive calls are made at every level for every element in the array.
 *
 * @param int[] $array
 * @param int $t
 * @param int $k
 * @return bool
 */
function hasKSumRecursive($array, $t, $k)
{
    foreach ($array as $number) {
        if ($k > 3) {
            if (hasKSumRecursive($array, $t - $number, $k - 1)) {
                return true;
            }
        } elseif (hasTwoSum($array, $t - $number)) {
            return true;
        }
    }

    return false;
}

/**
 * Determine if an array can two sum any of its elements to equal $t.  This works by iterating from each end of the
 * array and working toward the middle.  At each iteration the two numbers at $array[$j] and $array[$k] are added
 * together.  If the sum equals $t, the number can be two summed.  If the sum is less than $t, $j is incremented to
 * compare the next smallest number.  If the sum is greater than $t, $k is decremented to compare the next biggest
 * number.
 *
 * i.e.
 * If the input array is [1, 2, 3] and t is 3
 *
 * $j = 0
 * $k = 2
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is 1 + 3 = 3? No
 * Is 1 + 3 < 3? No
 * Is 1 + 3 > 3? Yes
 * $k = 1
 *
 * Iteration 2:
 * Is 1 + 2 = 3? Yes
 *
 * <<< WHILE LOOP TERMINATION: function return >>>
 *
 * return true
 *
 * @param int[] $array
 * @param int $t
 * @return bool
 */
function hasTwoSum($array, $t)
{
    $j = 0;
    $k = count($array) - 1;

    while ($j <= $k) {
        if ($array[$j] + $array[$k] == $t) {
            return true;
        } elseif ($array[$j] + $array[$k] < $t) {
            $j++;
        } else {
            $k--;
        }
    }

    return false;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of numbers as a json encoded array: '));
$k = json_decode($inputHelper->readInputFromStdIn('Enter the number of elements to add for the sum: '));
$t = (int) $inputHelper->readInputFromStdIn('Enter the number to test for ' . $k . '-sum: ');
$result = hasKSum($array, $t, $k);

if ($result) {
    printf('The array %s can be ' . $k . '-summed for %d', json_encode($array), $t);
} else {
    printf('The array %s can not be ' . $k . '-summed for %d', json_encode($array), $t);
}

print PHP_EOL;