<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity of the binary search strategy is O(m log n)
 * The time complexity of the linear advancement strategy is O(m + n)
 * Where m and n are the length of each input array respectively.
 */

/**
 * Compute the intersection of two arrays using either binary search or lienar advancement depending on the difference
 * in size of the two input arrays.
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function computeIntersection($array1 = [], $array2 = [])
{
    if (empty($array1) || empty($array2)) {
        throw new \InvalidArgumentException('Both input arrays must contain at least one value');
    }

    // Arbitrarily chosen difference used to determine the strategy
    if (abs(count($array1) - count($array2)) > 10) {
        return computeIntersectionUsingBinarySearch($array1, $array2);
    } else {
        return computeIntersectionUsingLinearAdvancement($array1, $array2);
    }
}

/**
 * Compute the intersection of two arrays using a binary search strategy.  This works by going through each element of
 * the smaller array and comparing it to the previous value as well as the values in the second array.  If the value is
 * a duplicate it is skipped.  If it is not a duplicate and exists in the second array, it is added to the intersection.
 * Binary search is not implemented here for brevity however we will treat in_array as if it was binary search.
 *
 * i.e.
 * If the input arrays are [4, 4, 5, 6] and [3, 4, 6, 7, 10, 11]
 *
 * $intersection = []
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * Is $i = 0 or $array[0] != $array[-1] and does $array2 contain 4? Yes
 * $intersection = [4]
 *
 * Iteration 2:
 * $i = 1
 * Is $i = 0 or $array[1] != $array[0] and does $array2 contain 4? No
 *
 * Iteration 3:
 * $i = 2
 * Is $i = 0 or $array[2] != $array[1] and does $array2 contain 4? No
 *
 * Iteration 4:
 * $i = 3
 * Is $i = 0 or $array[3] != $array[2] and does $array2 contain 6? Yes
 * $intersection = [4, 6]
 *
 * <<< FOR LOOP TERMINATION: $i = count of the smaller array >>>
 *
 * $intersection = [4, 6]
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function computeIntersectionUsingBinarySearch($array1 = [], $array2 = [])
{
    $intersection = [];

    for ($i = 0; $i < (count($array1) < count($array2) ? count($array1) : count($array2)); $i++) {
        if (($i == 0 || $array1[$i] != $array1[$i - 1]) && in_array($array1[$i], $array2)) {
            $intersection[] = $array1[$i];
        }
    }

    return $intersection;
}

/**
 * Compute the intersection of two arrays using a linear advancement strategy.  This works by advancing each array to
 * keep them in sync and comparing items in each.  It starts with the first index of each and if those values are the
 * same, the value is added to the intersection.  If they are not the same, the index associated with the smaller value
 * is incremented.
 *
 * i.e
 * If the input arrays are [1, 2, 3, 4, 5] and [2, 4, 6, 8, 10]
 *
 * $i = 0
 * $j = 0
 * $intersection = []
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is $array1[0] == $array2[0] and $i == 0 or $array[0] != $array[-1]? No
 * Is $array1[0] < $array2[0]? Yes
 * $i = 1
 *
 * Iteration 2:
 * Is $array1[1] == $array2[0] and $i == 0 or $array[1] != $array[0]? Yes
 * $intersection = [2]
 * $i = 2
 * $j = 1
 *
 * Iteration 3:
 * Is $array1[2] == $array2[1] and $i == 0 or $array[2] != $array[1]? No
 * Is $array1[2] < $array2[1]? Yes
 * $i = 3
 *
 * Iteration 4:
 * Is $array1[3] == $array2[1] and $i == 0 or $array[3] != $array[2]? Yes
 * $intersection = [2, 4]
 * $i = 4
 * $j = 2
 *
 * Iteration 5:
 * Is $array1[4] == $array2[2] and $i == 0 or $array[4] != $array[3]? No
 *
 * <<< WHILE LOOP TERMINATION: $i = count($array1) - 1 >>>
 *
 * $intersection = [2, 4]
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function computeIntersectionUsingLinearAdvancement($array1 = [], $array2 = [])
{
    $i = 0;
    $j = 0;
    $intersection = [];

    while ($i < count($array1) && $j < count($array2)) {
        if ($array1[$i] == $array2[$j] && ($i == 0 || $array1[$i] != $array1[$i - 1])) {
            $intersection[] = $array1[$i];
            $i++;
            $j++;
        } elseif ($array1[$i] < $array2[$j]) {
            $i++;
        } else {
            $j++;
        }
    }

    return $intersection;
}

$inputHelper = new InputHelper();
$array1 = json_decode($inputHelper->readInputFromStdIn('Enter the first array in json format: '));
$array2 = json_decode($inputHelper->readInputFromStdIn('Enter the second array in json format: '));
$result = computeIntersection($array1, $array2);

printf('The intersection of %s and %s is %s', json_encode($array1), json_encode($array2), json_encode($result));
print PHP_EOL;