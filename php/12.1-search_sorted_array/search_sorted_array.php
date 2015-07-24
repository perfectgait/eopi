<?php

/**
 * Search a sorted array for the first occurrence of a value.
 *
 * The time complexity of searchSortedArray is O(log n) because the search candidates are reduced by 1/2 each iteration.
 */

/**
 * Search a sorted array for the first occurrence of a value
 *
 * @param array $array
 * @param $value
 * @return int
 */
function searchSortedArray(array $array = [], $value)
{
    $left = 0;
    $right = count($array) - 1;
    $result = -1;

    while ($left <= $right) {
        $middle = $left + floor(($right - $left) / 2);

        if ($array[$middle] > $value) {
            // If the array value is greater than the value being searched for, it has to be in the left half of the
            // array.
            $right = $middle - 1;
        } elseif($array[$middle] == $value) {
            // If the array value is the same as the value being searched for, continue searching the left half of the
            // array for any occurrence prior.
            $result = $middle;
            $right = $middle - 1;
        } else {
            // If the array value is less than the value being searched for, it has to be in the right half of the
            // array.
            $left = $middle + 1;
        }
    }

    return $result;
}

$array = [-14, -10, 2, 108, 108, 243, 285, 285, 285, 401];
$result = searchSortedArray($array, 108);

print $result . PHP_EOL;

$array2 = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
$result2 = searchSortedArray($array2, 1);

print $result2 . PHP_EOL;