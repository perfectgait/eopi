<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n)
 */

/**
 * Partition an array of elements with keys that have a boolean value.  Each section will contain elements with matching
 * keys.  This works by keeping track of 3 sections of a contiguous array.  The array is partitioned into, left,
 * unexplored and right sections.  As the loop iterates through each element in the array, the current elements key is
 * looked at.
 *
 * If it is false, the current element is left in place.  Then the middle index is incremented by one.
 *
 * If it is true, the current element is swapped with the element at the current right index.  Then the right index is
 * decremented by one.
 *
 * At the end of the iteration, the unexplored section is gone, leaving just a left and right section.
 *
 * i.e.
 * If the array is [{"key":false},{"key":true},{"key":false},{"key":true},{"key":false},{"key":true}]
 *
 * $left = 0
 * $right = 5
 *
 * Iteration 1:
 * key is false
 * $left = 1
 * $right = 5
 * [{"key":false},{"key":true},{"key":false},{"key":true},{"key":false},{"key":true}]
 *
 * Iteration 2:
 * key is true
 * $left = 1
 * $right = 4
 * [{"key":false},{"key":true},{"key":false},{"key":true},{"key":false},{"key":true}]
 *
 * Iteration 3:
 * key is true
 * $left = 1
 * $right = 3
 * [{"key":false},{"key":false},{"key":false},{"key":true},{"key":true},{"key":true}]
 *
 * Iteration 4:
 * key is false
 * $left = 2
 * $right = 3
 * [{"key":false},{"key":false},{"key":false},{"key":true},{"key":true},{"key":true}]
 *
 * Iteration 5:
 * key is false
 * $left = 3
 * $right = 3
 * [{"key":false},{"key":false},{"key":false},{"key":true},{"key":true},{"key":true}]
 *
 * Iteration 6:
 * key is true
 * $left = 3
 * $right = 2
 * [{"key":false},{"key":false},{"key":false},{"key":true},{"key":true},{"key":true}]
 *
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartitionVariant3($array)
{
    $left = 0;
    $right = count($array) - 1;

    while ($left <= $right) {
        if ($array[$left]->key === false) {
            $left++;
        } else {
            swapElements($array, $left, $right--);
        }
    }

    return $array;
}

/**
 * Swap elements in an array
 *
 * @param array $array
 * @param int $index1
 * @param int $index2
 */
function swapElements(&$array, $index1, $index2)
{
    $firstElement = $array[$index1];
    $array[$index1] = $array[$index2];
    $array[$index2] = $firstElement;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of objects in json format: '));
$result = dutchNationalFlagPartitionVariant3($array);

printf('Partitioning the array %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;