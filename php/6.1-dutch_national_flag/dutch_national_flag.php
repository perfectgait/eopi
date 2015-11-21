<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n)
 */

/**
 * Partition an array like the Dutch national flag (into 3 sections).  This works by keeping track of 4 sections of a
 * contiguous array.  The array is partitioned into, smaller, equal, unexplored and larger sections.  As the loop
 * iterates through each element in the array, the element is compared to the pivot.
 *
 * If it is less than the pivot, the element is swapped with the element at the current smallest index.  Then the
 * current equal index and smallest index are incremented by one.
 *
 * If it is equal to the pivot, the element is left in place and the equal index is incremented by one.
 *
 * If it is greater than the pivot, the element is swapped with the element at the current largest index and the current
 * largest index is decremented by one.
 *
 * At the end of the iteration, the unexplored section is gone, leaving just a smaller, equal and larger section.
 *
 * i.e.
 * If the array is [7, 3, 9, 0, 6, 5, 1, 4, 2, 8] and the index is 5
 *
 * $pivot = 5
 * $smaller = 0
 * $equal = 0
 * $larger = 9
 *
 * Iteration 1:
 * 7 is greater than 5
 * A = [8, 3, 9, 0, 6, 5, 1, 4, 2, 7]
 * $smaller = 0
 * $equal = 0
 * $larger = 8
 *
 * Iteration 2:
 * 8 is greater than 5
 * A = [2, 3, 9, 0, 6, 5, 1, 4, 8, 7]
 * $smaller = 0
 * $equal = 0
 * $larger = 7
 *
 * Iteration 3:
 * 2 is less than 5
 * A = [2, 3, 9, 0, 6, 5, 1, 4, 8, 7]
 * $smaller = 1
 * $equal = 1
 * $larger = 7
 *
 * Iteration 4:
 * 3 is less than 5
 * A = [2, 3, 9, 0, 6, 5, 1, 4, 8, 7]
 * $smaller = 2
 * $equal = 2
 * $larger = 7
 *
 * Iteration 5:
 * 9 is greater than 5
 * A = [2, 3, 4, 0, 6, 5, 1, 9, 8, 7]
 * $smaller = 2
 * $equal = 2
 * $larger = 6
 *
 * Iteration 6:
 * 4 is less than 5
 * A = [2, 3, 4, 0, 6, 5, 1, 9, 8, 7]
 * $smaller = 3
 * $equal = 3
 * $larger = 6
 *
 * Iteration 7:
 * 0 is less than 5
 * A = [2, 3, 4, 0, 6, 5, 1, 9, 8, 7]
 * $smaller = 4
 * $equal = 4
 * $larger = 6
 *
 * Iteration 8:
 * 6 is greater than 5
 * A = [2, 3, 4, 0, 1, 5, 6, 9, 8, 7]
 * $smaller = 4
 * $equal = 4
 * $larger = 5
 *
 * Iteration 9:
 * 1 is less than 5
 * A = [2, 3, 4, 0, 1, 5, 6, 9, 8, 7]
 * $smaller = 5
 * $equal = 5
 * $larger = 5
 *
 * Iteration 10:
 * 5 is equal to 5
 * A = [2, 3, 4, 0, 1, 5, 6, 9, 8, 7]
 * $smaller = 5
 * $equal = 6
 * $larger = 5
 *
 * @param int $index
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartition($index, $array)
{
    if (!isset($array[$index])) {
        throw new \OutOfBoundsException('The $index does not exist in the $array');
    }

    $pivot = $array[$index];
    $smaller = 0;
    $equal = 0;
    $larger = count($array) - 1;

    while ($equal <= $larger) {
        if ($array[$equal] < $pivot) {
            swapElements($array, $smaller++, $equal++);
        } elseif($array[$equal] == $pivot) {
            $equal++;
        } else {
            swapElements($array, $equal, $larger--);
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
$array = explode(',', $inputHelper->readInputFromStdIn('Enter the array of integers as a comma separated string: '));
$index = $inputHelper->readInputFromStdIn('Enter the index to use as the pivot: ');
$result = dutchNationalFlagPartition($index, $array);

printf('Partitioning the array %s results in %s.', '[' . implode(',', $array) . ']', '[' . implode(',', $result) . ']');
print PHP_EOL;