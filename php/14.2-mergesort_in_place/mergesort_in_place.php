<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The running time is O(m + n) and the space complexity is O(1)
 */

/**
 * This works by iterating through both arrays until one is exhausted, writing the largest value at each iteration to
 * the end of first array.  At each iteration, the end of the first array is reduced by one.  After these iterations, if
 * there are more values in the second array to be iterated through, they will be written to the first array, starting
 * at the current end point, working towards the front.  If there are more values in the first array nothing needs to be
 * done because those values are already in sorted order and are already at the front of the array.
 *
 * i.e.
 * If the input arrays are [5, 13, 17, _, _, _, _] and [3, 7, 11, 19], $m is 2 and $n is 3
 *
 * $writeIndex = 6
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $m = 2
 * $n = 3
 * Is 17 > 19? No
 * $array1 = [5, 13, 17, _, _, _, 19]
 * $writeIndex = 5
 * $n = 2
 *
 * Iteration 2:
 * $m = 2
 * $n = 2
 * Is 17 > 11? Yes
 * $array1 = [5, 13, 17, _, _, 17, 19]
 * $writeIndex = 4
 * $m = 1
 *
 * Iteration 3:
 * $m = 1
 * $n = 2
 * Is 13 > 11? Yes
 * $array1 = [5, 13, 17, _, 13, 17, 19]
 * $writeIndex = 3
 * $m = 0
 *
 * Iteration 4:
 * $m = 0
 * $n = 2
 * Is 5 > 11? No
 * $array1 = [5, 13, 17, 11, 13, 17, 19]
 * $writeIndex = 2
 * $n = 1
 *
 * Iteration 5:
 * $m = 0
 * $n = 1
 * Is 5 > 7? No
 * $array1 = [5, 13, 7, 11, 13, 17, 19]
 * $writeIndex = 1
 * $n = 0
 *
 * Iteration 6:
 * $m = 0
 * $n = 0
 * Is 5 > 3? Yes
 * $array1 = [5, 5, 7, 11, 13, 17, 19]
 * $writeIndex = 0
 * $m = 0
 *
 * <<< WHILE LOOP TERMINATION: $m == 0 >>>
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $array1 = [3, 5, 7, 11, 13, 17, 19]
 * $writeIndex = -1
 * $n = 0
 *
 * <<< WHILE LOOP TERMINATION: $n == 0 >>>
 *
 * [3, 5, 7, 11, 13, 17, 19] is returned
 *
 * @param SplFixedArray $array1
 * @param int $m
 * @param SplFixedArray $array2
 * @param int $n
 * @return SplFixedArray
 */
function mergeTwoSortedArrays(\SplFixedArray $array1, $m, \SplFixedArray $array2, $n)
{
    $writeIndex = $m + $n + 1;

    while ($m >= 0 && $n >= 0) {
        $array1[$writeIndex--] = $array1[$m] > $array2[$n] ? $array1[$m--] : $array2[$n--];
    }

    while ($n >= 0) {
        $array1[$writeIndex--] = $array2[$n--];
    }

    return $array1;
}

$inputHelper = new InputHelper();
$inputArray1 = json_decode($inputHelper->readInputFromStdIn('Enter the first array of sorted integers in json format: '));
$inputArray2 = json_decode($inputHelper->readInputFromStdIn('Enter the second array of sorted integers in json format: '));
$fixedArray1 = \SplFixedArray::fromArray($inputArray1);
$fixedArray2 = \SplFixedArray::fromArray($inputArray2);
$fixedArray1->setSize($fixedArray1->getSize() + $fixedArray2->getSize());
$result = mergeTwoSortedArrays($fixedArray1, count($inputArray1) - 1, $fixedArray2, count($inputArray2) - 1);

printf(
    'The result of combining %s and %s is %s.',
    json_encode($inputArray1),
    json_encode($inputArray2),
    json_encode($result->toArray())
);
print PHP_EOL;