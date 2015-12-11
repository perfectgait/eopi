<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array
 */

/**
 * Delete a key from an array and return the number of remaining elements in the array.  This works by going through the
 * array and looking at each value.  If the value does not match the key to be removed, the value is written back into
 * the array.  If the value does match the key to be removed, the value is skipped.  In the end we have an array with
 * all entries that don't match the key at the beginning and then potentially extra entries after that.
 *
 * i.e.
 *
 * If the array is [5, 3, 7, 11, 2, 3, 13, 5, 7] and the key is 3
 *
 * $writeIndex = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * Is $array[$i](5) != $key(3)?, Yes
 * $array = [5,3,7,11,2,3,13,5,7]
 * $writeIndex = 1
 *
 * Iteration 2:
 * $i = 1
 * Is $array[$i](3) != $key(3)?, No
 * $array = [5,3,7,11,2,3,13,5,7]
 * $writeIndex = 1
 *
 * Iteration 3:
 * $i = 2
 * Is $array[$i](7) != $key(3)?, Yes
 * $array = [5,7,7,11,2,3,13,5,7]
 * $writeIndex = 2
 *
 * Iteration 4:
 * $i = 3
 * Is $array[$i](11) != $key(3)?, Yes
 * $array = [5,7,11,11,2,3,13,5,7]
 * $writeIndex = 3
 *
 * Iteration 5:
 * $i = 4
 * Is $array[$i](2) != $key(3)?, Yes
 * $array = [5,7,11,2,2,3,13,5,7]
 * $writeIndex = 4
 *
 * Iteration 6:
 * $i = 5
 * Is $array[$i](3) != $key(3)?, No
 * $array = [5,7,11,2,2,3,13,5,7]
 * $writeIndex = 4
 *
 * Iteration 7:
 * $i = 6
 * Is $array[$i](13) != $key(3)?, Yes
 * $array = [5,7,11,2,13,3,13,5,7]
 * $writeIndex = 5
 *
 * Iteration 8:
 * $i = 7
 * Is $array[$i](5) != $key(3)?, Yes
 * $array = [5,7,11,2,13,5,13,5,7]
 * $writeIndex = 6
 *
 * Iteration 9:
 * $i = 8
 * Is $array[$i](7) != $key(3)?, Yes
 * $array = [5,7,11,2,13,5,7,5,7]
 * $writeIndex = 7
 *
 * <<< LOOP TERMINATION: $i == count($array) - 1 >>>
 *
 * The length of the array without the key is 7
 *
 * @param array $array
 * @param mixed $key
 * @return int
 */
function deleteArrayKey(array $array, $key)
{
    if (count($array) < 1) {
        throw new \InvalidArgumentException('$array is empty');
    }

    $writeIndex = 0;

    for ($i = 0; $i < count($array) - 1; $i++) {
        if ($array[$i] != $key) {
            $array[$writeIndex++] = $array[$i];
        }
    }

    return ++$writeIndex;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of integers in json format: '));
$key = trim($inputHelper->readInputFromStdIn('Enter the key to delete: '));
$result = deleteArrayKey($array, $key);

printf('The size of %s after removing the key %s is %d', json_encode($array), $key, $result);
print PHP_EOL;