<?php

require_once '../autoload.php';

use \EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the space complexity is O(1)
 */

/**
 * Determine if an array can sum three unique elements to equal $t.  This works by going through each element and seeing
 * if $array can be two-summed to equal $t - $array[$index].  If it can then the array can be three-summed by just
 * adding $array[$index].  It also passes the current index to the unique two sum function to ensure that the index is
 * not re-used in the two-sum calculation.
 *
 * i.e.
 * If the input array is [5, 2, 3, 4, 3] and t is 9
 *
 * $array = [2, 3, 3, 4, 5]
 *
 * <<< FOREACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $number = 2
 * $index = 0
 * Is there a unique two sum that equals 7?  Yes, 3 + 4
 *
 * <<< FOREACH LOOP TERMINATION: function return >>>
 *
 * return true
 *
 * @param int[] $array
 * @param int $t
 * @return bool
 */
function hasUniqueThreeSum($array, $t)
{
    if (empty($array)) {
        throw new \InvalidArgumentException('The input $array cannot be empty');
    }

    if ($t > PHP_INT_MAX || $t < (PHP_INT_MAX + 1) * -1) {
        throw new \InvalidArgumentException(
            '$t must be between ' . ((PHP_INT_MAX + 1) * -1) . ' and ' . PHP_INT_MAX
        );
    }

    sort($array);

    foreach ($array as $index => $number) {
        if (hasUniqueTwoSum($array, $t - $number, $index)) {
            return true;
        }
    }

    return false;
}

/**
 * Determine if an array can sum two unique elements to equal $t.  This works by comparing items at each end of the
 * array and working towards the middle until a sum that matches $t can be found.  If $array[$j + $array[$k] = $t, a sum
 * is found.  If $array[$j] + $array[$k] < $t, $j is incremented so the next smallest number can be compared.  If
 * $array[$j] + $array[$k] > $k, $k is decremented so the next biggest number can be compared.  If either $j or $k =
 * $ignoreIndex, they are incremented or decremented respectively.  This will avoid using the same index twice.  The
 * loop terminates when $j = $k - 1 to avoid comparing the same element for a match.
 *
 * i.e.
 * If the input array is [2, 3, 3, 4, 5] and t is 7
 *
 * $j = 0;
 * $k = 4
 *
 * Is $j == $ignoreIndex? Yes
 * $j = 1
 *
 * Is $k == $ignoreIndex? No
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is 3 + 5 = 7? No
 * Is 3 + 5 < 7? No
 * Is 3 + 5 > 7? Yes
 * $k = 3
 *
 * Is $j == $ignoreIndex? No
 * Is $k == $ignoreIndex? No
 *
 * Iteration 2:
 * Is 3 + 4 = 7? Yes
 *
 * <<< WHILE LOOP TERMINATION: function return >>>
 *
 * return true
 *
 * @param int[] $array
 * @param int $t
 * @param int $ignoreIndex
 * @return bool
 */
function hasUniqueTwoSum($array, $t, $ignoreIndex)
{
    $j = 0;
    $k = count($array) - 1;

    if ($j == $ignoreIndex) {
        $j++;
    }

    if ($k == $ignoreIndex) {
        $k--;
    }

    while ($j < $k) {
        if ($array[$j] + $array[$k] == $t) {
            return true;
        } elseif ($array[$j] + $array[$k] < $t) {
            $j++;
        } else {
            $k--;
        }

        if ($j == $ignoreIndex) {
            $j++;
        }

        if ($k == $ignoreIndex) {
            $k--;
        }
    }

    return false;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of numbers as a json encoded array: '));
$t = (int) $inputHelper->readInputFromStdIn('Enter the number to test for 3-sum: ');
$result = hasUniqueThreeSum($array, $t);

if ($result) {
    printf('The array %s can be uniquely 3-summed for %d', json_encode($array), $t);
} else {
    printf('The array %s can not be uniquely 3-summed for %d', json_encode($array), $t);
}

print PHP_EOL;