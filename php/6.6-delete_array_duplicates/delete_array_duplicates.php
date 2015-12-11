<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array
 */

/**
 * Delete duplicated entries from an array.  This works by iterating through the array and comparing the current value
 * with the value at the write index.  If the two differ, the current value is written into the slot after the current
 * write index and the write index is incremented by one.  Since the array is sorted we know that if the current value
 * does not match the value at the current write index, it has not been seen previously.
 *
 * i.e.
 *
 * If the array is [2, 3, 5, 5, 7, 11, 11, 11, 13]
 *
 * $writeIndex = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 1
 * Is $array[$writeIndex](2) != $array[$i](3)?, Yes
 * $writeIndex = 1
 * $array = [2,3,5,5,7,11,11,11,13]
 *
 * Iteration 2:
 * $i = 2
 * Is $array[$writeIndex](3) != $array[$i](5)?, Yes
 * $writeIndex = 2
 * $array = [2,3,5,5,7,11,11,11,13]
 *
 * Iteration 3:
 * $i = 3
 * Is $array[$writeIndex](5) != $array[$i](5)?, No
 * $writeIndex = 2
 * $array = [2,3,5,5,7,11,11,11,13]
 *
 * Iteration 4:
 * $i = 4
 * Is $array[$writeIndex](5) != $array[$i](7)?, Yes
 * $writeIndex = 3
 * $array = [2,3,5,7,7,11,11,11,13]
 *
 * Iteration 5:
 * $i = 5
 * Is $array[$writeIndex](7) != $array[$i](11)?, Yes
 * $writeIndex = 4
 * $array = [2,3,5,7,11,11,11,11,13]
 *
 * Iteration 6:
 * $i = 6
 * Is $array[$writeIndex](11) !- $array[$i](11)?, No
 * $writeIndex = 4
 * $array = [2,3,5,7,11,11,11,11,13]
 *
 * Iteration 7:
 * $i = 7
 * Is $array[$writeIndex](11) != $array[$i](11)?, No
 * $writeIndex = 4
 * $array = [2,3,5,7,11,11,11,11,13]
 *
 * Iteration 8:
 * $i = 8
 * Is $array[$writeIndex](11) != $array[$i](13)?, Yes
 * $writeIndex = 5
 * $array = [2,3,5,7,11,13,11,11,13]
 *
 * <<< LOOP TERMINATION: $i == count($array) >>>
 *
 * The length of the array without duplicates is 6
 *
 * @param array $array
 * @return int
 */
function deleteArrayDuplicates(array $array)
{
    if (count($array) < 2) {
        return count($array);
    }

    $writeIndex = 0;

    for ($i = 1; $i < count($array); ++$i) {
        if ($array[$writeIndex] != $array[$i]) {
            $array[++$writeIndex] = $array[$i];
        }
    }

    return $writeIndex + 1;
}


$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the sorted array of integers in json format: '));
$result = deleteArrayDuplicates($array);

printf('The size of %s after removing the duplicates is %d', json_encode($array), $result);
print PHP_EOL;