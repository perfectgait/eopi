<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1) and this uses O(1) more space that the original problem to store the left key
 */

/**
 * Partition an array of elements with keys that can take one of three values into three sections.  Each section will
 * contain elements with matching keys.  This works by keeping track of 4 sections of a contiguous array.  The array is
 * partitioned into, left, middle, unexplored and right sections.  As the loop iterates through each element in the
 * array, the current elements key is compared with the pivot.
 *
 * If it is equal to the pivot, the element is left in place and the middle index is incremented by one.
 *
 * If it is not equal to the pivot and there is no left key or it is equal to the left key, the element is swapped with
 * the element at the current left index.  Then the left index and middle index are incremented by one.
 *
 * If it is not equal to the pivot or the left key, the element is swapped with the element at the current right index.
 * Then the right index is decremented by one.
 *
 * At the end of the iteration, the unexplored section is gone, leaving just a left, middle and right section.
 *
 * i.e.
 * If the array is [{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"}] and the index is 2
 *
 * $pivot = 3
 * $leftKey = null
 * $left = 0
 * $middle = 0
 * $right = 9
 *
 * Iteration 1:
 * 1 is not equal to 3 and there is no left key
 * A = [{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"}]
 * $leftKey = 1
 * $left = 1
 * $middle = 1
 * $right = 9
 *
 * Iteration 2:
 * 2 is not equal to 3 or 1
 * A = [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"}]
 * $leftKey = 1
 * $left = 1
 * $middle = 1
 * $right = 8
 *
 * Iteration 3:
 * 1 is not equal to 3 but is equal to 1
 * A = [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"}]
 * $leftKey = 1
 * $left = 2
 * $middle = 2
 * $right = 8
 *
 * Iteration 4:
 * 3 is equal to 3
 * A = [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"}]
 * $leftKey = 1
 * $left = 2
 * $middle = 3
 * $right = 8
 *
 * Iteration 5:
 * 1 is not equal to 3 but is equal to 1
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"2"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"}]
 * $leftKey = 1
 * $left = 3
 * $middle = 4
 * $right = 8
 *
 * Iteration 6:
 * 2 is not equal to 3 or 1
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"2"},{"key":"2"}]
 * $leftKey = 1
 * $left = 3
 * $middle = 4
 * $right = 7
 *
 * Iteration 7:
 * 3 is equal to 3
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"2"},{"key":"2"}]
 * $leftKey = 1
 * $left = 3
 * $middle = 5
 * $right = 7
 *
 * Iteration 8:
 * 3 is equal to 3
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"2"},{"key":"2"}]
 * $leftKey = 1
 * $left = 3
 * $middle = 6
 * $right = 7
 *
 * Iteration 9:
 * 1 is not equal to 3 but is equal to 1
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"2"},{"key":"2"},{"key":"2"}]
 * $leftKey = 1
 * $left = 4
 * $middle = 7
 * $right = 7
 *
 * Iteration 10:
 * 2 is not equal to 3 or 1
 * A = [{"key":"1"},{"key":"1"},{"key":"1"},{"key":"1"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"2"},{"key":"2"},{"key":"2"}]
 * $leftKey = 1
 * $left = 4
 * $middle = 7
 * $right = 6
 *
 * @param int $index
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartitionVariant1($index, $array)
{
    if (!isset($array[$index])) {
        throw new \OutOfBoundsException('The $index does not exist in the $array');
    }

    $pivot = $array[$index]->key;
    $leftKey = null;
    $left = 0;
    $middle = 0;
    $right = count($array) - 1;

    while ($middle <= $right) {
        if ($array[$middle]->key == $pivot) {
            $middle++;
        } elseif (empty($leftKey) || $array[$middle]->key == $leftKey) {
            if (empty($leftKey)) {
                $leftKey = $array[$middle]->key;
            }

            swapElements($array, $left++, $middle++);
        } else {
            swapElements($array, $middle, $right--);
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
$index = $inputHelper->readInputFromStdIn('Enter the index to use as the pivot: ');
$result = dutchNationalFlagPartitionVariant1($index, $array);

printf('Partitioning the array %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;