<?php

require_once '../autoload.php';

use \EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) and the space complexity is O(1)
 */

/**
 * Determine if an array can three sum any of its elements to equal $t.  This works by going through each element and
 * determining if there is a two sum that will equal $t - $number.  If there is, a three sum can be achieved by adding
 * $number.
 *
 * i.e.
 * If the input array is [1, 2, 3] and t is 5
 *
 * <<< FOREACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $number = 1
 * Is there a two sum that equals 4?  Yes, 1 + 3
 *
 * <<< FOREACH LOOP TERMINATION: function return >>>
 *
 * return true
 *
 * @param int[] $array
 * @param int $t
 * @return bool
 */
function hasThreeSum($array, $t)
{
    if (empty($array)) {
        throw new \InvalidArgumentException('The input $array cannot be empty');
    }

    if ($t > PHP_INT_MAX || $t < (PHP_INT_MAX + 1) * -1) {
        throw new \InvalidArgumentException(
            '$t must be between ' . ((PHP_INT_MAX + 1) * -1) . ' and ' . PHP_INT_MAX
        );
    }

    asort($array);

    foreach ($array as $number) {
        if (hasTwoSum($array, $t - $number)) {
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
$t = (int) $inputHelper->readInputFromStdIn('Enter the number to test for 3-sum: ');
$result = hasThreeSum($array, $t);

if ($result) {
    printf('The array %s can be 3-summed for %d', json_encode($array), $t);
} else {
    printf('The array %s can not be 3-summed for %d', json_encode($array), $t);
}

print PHP_EOL;