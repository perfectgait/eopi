<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array
 */

/**
 * Find the lest of the longest sub-array in the input array.  This works by iterating through the input array and
 * comparing the current value to the last value that may be different.  If the values are the same, nothing happens
 * and the iteration continues.  If they are different, the longest sub-array is re-calculated by comparing the current
 * longest sub-array to the new sub-array (found by subtracting the current index from the last index containing the
 * value that may be different).  If the new one is bigger, it becomes the new longest sub-array.  At the end of the
 * iteration one more check is done in case the longest sub-array lies at the end of the input array.
 *
 * i.e.
 *
 * If the input array is [1,1,1,2,2,3,3,3,3]
 *
 * $index = 0
 * $longestSubarray = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * Is $array[$index] != $array[$i]? No
 *
 * Iteration 2:
 * $i = 1
 * Is $array[$index] != $array[$i]? No
 *
 * Iteration 3:
 * $i = 2
 * Is $array[$index] != $array[$i]? No
 *
 * Iteration 4:
 * $i = 3
 * Is $array[$index] != $array[$i]? Yes
 * Is $i(3) - $index(0) = 3 > $longestSubarray(0)? Yes
 * $longestSubarray = 3
 * $index = 3
 *
 * Iteration 5:
 * $i = 4
 * Is $array[$index] != $array[$i]? No
 *
 * Iteration 6:
 * $i = 5
 * Is $array[$index] != $array[$i]? Yes
 * Is $i(5) - $index(3) = 2 > $longestSubarray(3)? No
 * $longestSubarray = 3
 * $index = 5
 *
 * Iteration 7:
 * $i = 6
 * Is $array[$index] != $array[$i]? No
 * $longestSubarray = 3
 * $index = 5
 *
 * Iteration 8:
 * $i = 7
 * Is $array[$index] != $array[$i]? No
 * $longestSubArray = 3
 * $index = 5
 *
 * Iteration 9:
 * $i = 8
 * Is $array[$index] != $array[$i]? No
 * $longestSubarray = 3
 * $index = 5
 *
 * <<< LOOP TERMINATION: all values have been iterated through >>>
 *
 * $index(5) is not equal to $i(8) so we do one more check
 * Is ($i + 1)(9) - $index(5) = 4 > $longestSubarray? Yes
 * $longestSubarray = 4
 *
 * @param array $array
 * @return int
 */
function findLongestSubarrayLength($array)
{
    if (empty($array)) {
        return 0;
    }

    $index = 0;
    $longestSubarray = 0;

    for ($i = 0; $i < count($array) - 1; $i++) {
        if ($array[$index] != $array[$i]) {
            $longestSubarray = max($longestSubarray, $i - $index);
            $index = $i;
        }
    }

    // Perform one last check in case the longest sub-array is at the end of the input array
    if ($index != $i) {
        // $i ended while pointing at the last index in the array which needs to be included in the count so add 1
        $longestSubarray = max($longestSubarray, $i + 1 - $index);
    }

    return $longestSubarray;
}


$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of integers in json format: '));
$result = findLongestSubarrayLength($array);

printf('The length of the longest sub-array in %s is %d', json_encode($array), $result);
print PHP_EOL;