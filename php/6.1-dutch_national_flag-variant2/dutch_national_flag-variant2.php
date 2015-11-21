<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and this uses O(1) more space than the original problem to store the left key, right key
 * and left 2 index.
 */

/**
 * Partition an array of elements with keys that can take one of four values into four sections.  Each section will
 * contain elements with matching keys.  This works by keeping track of 5 sections of a contiguous array.  The array is
 * partitioned into, left, left2, middle, unexplored and right sections.  As the loop iterates through each element in
 * the array, the current elements key is compared with the pivot.
 *
 * If it is equal to the pivot, the element is left in place and the middle index is incremented by one.
 *
 * If it is not equal to the pivot and there is no left key or it is equal to the left key, the element is swapped with
 * the element at the current left index.  Then the element is swapped with the element at the current left2 index.
 * This is the key to maintaining to integrity of the left and left2 sections of the array.  Then the left index, left2
 * index and middle index are incremented by one.
 *
 * If it is not equal to the pivot and there is no right key or it is equal to the right key, the element is swapped
 * with the element at the current right index. Then the right index is decremented by one.
 *
 * If it is not equal to the pivot, the left index or the right index, the element is swapped with the element at the
 * current left2 index.  Then the left2 index and middle index are incremented by one.
 *
 * At the end of the iteration, the unexplored section is gone, leaving just a left, left2, middle and right section.
 *
 * i.e.
 * If the array is [{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"}]
 * and the index is 2
 *
 * $pivot: 3
 * $leftKey: null
 * $rightKey: null
 * $left: 0
 * $left2: 0
 * $middle: 0
 * $right: 12
 *
 * Iteration 1:
 * 1 is not equal to 3 and the left key is not set
 * leftKey: 1
 * rightKey: null
 * left: 1
 * left2: 1
 * middle: 1
 * right: 12
 * A: [{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"}]
 *
 * Iteration 2:
 * 2 is not equal to 3 or 1 and the right key is not set
 * leftKey: 1
 * rightKey: 2
 * left: 1
 * left2: 1
 * middle: 1
 * right: 11
 * A: [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"2"}]
 *
 * Iteration 3:
 * 1 is not equal to 3 but is equal to 1
 * leftKey: 1
 * rightKey: 2
 * left: 2
 * left2: 2
 * middle: 2
 * right: 11
 * A: [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"2"}]
 *
 * Iteration 4:
 * 3 is equal to 3
 * leftKey: 1
 * rightKey: 2
 * left: 2
 * left2: 2
 * middle: 3
 * right: 11
 * A: [{"key":"1"},{"key":"1"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"2"}]
 *
 * Iteration 5:
 * 4 is not equal to 3 or 1 or 2
 * leftKey: 1
 * rightKey: 2
 * left: 2
 * left2: 3
 * middle: 4
 * right: 11
 * A: [{"key":"1"},{"key":"1"},{"key":"4"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"2"}]
 *
 * Iteration 6:
 * 1 is not equal to 3 but is equal to 1
 * leftKey: 1
 * rightKey: 2
 * left: 3
 * left2: 4
 * middle: 5
 * right: 11
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"4"},{"key":"3"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"4"},{"key":"2"}]
 *
 * Iteration 7:
 * 2 is not equal to 3 or 1 but is equal to 2
 * leftKey: 1
 * rightKey: 2
 * left: 3
 * left2: 4
 * middle: 5
 * right: 10
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"4"},{"key":"3"},{"key":"4"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 8:
 * 4 is not equal to 3 or 1 or 2
 * leftKey: 1
 * rightKey: 2
 * left: 3
 * left2: 5
 * middle: 6
 * right: 10
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 9:
 * 3 is equal to 3
 * leftKey: 1
 * rightKey: 2
 * left: 3
 * left2: 5
 * middle: 7
 * right: 10
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"4"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 10:
 * 4 is not equal to 3 or 1 or 2
 * leftKey: 1
 * rightKey: 2
 * left: 3
 * left2: 6
 * middle: 8
 * right: 10
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"4"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"1"},{"key":"2"},{"key":"3"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 11:
 * 1 is not equal to 3 but is equal to 1
 * leftKey: 1
 * rightKey: 2
 * left: 4
 * left2: 7
 * middle: 9
 * right: 10
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"1"},{"key":"4"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"2"},{"key":"3"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 12:
 * 2 is not equal to 3 or 1 but is equal to 2
 * leftKey: 1
 * rightKey: 2
 * left: 4
 * left2: 7
 * middle: 9
 * right: 9
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"1"},{"key":"4"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"2"},{"key":"2"},{"key":"2"}]
 *
 * Iteration 13:
 * 3 is equal to 3
 * leftKey: 1
 * rightKey: 2
 * left: 4
 * left2: 7
 * middle: 10
 * right: 9
 * A: [{"key":"1"},{"key":"1"},{"key":1"},{"key":"1"},{"key":"4"},{"key":"4"},{"key":"4"},{"key":"3"},{"key":"3"},{"key":"3"},{"key":"2"},{"key":"2"},{"key":"2"}]
 *
 * @param int $index
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartitionVariant2($index, $array)
{
    if (!isset($array[$index])) {
        throw new \OutOfBoundsException('The $index does not exist in the $array');
    }

    $pivot = $array[$index]->key;
    $leftKey = null;
    $left = 0;
    $left2 = 0;
    $middle = 0;
    $rightKey = null;
    $right = count($array) - 1;

    while ($middle <= $right) {
        if ($array[$middle]->key == $pivot) {
            $middle++;
        } elseif (empty($leftKey) || $array[$middle]->key == $leftKey) {
            if (empty($leftKey)) {
                $leftKey = $array[$middle]->key;
            }

            swapElements($array, $left++, $middle);
            swapElements($array, $left2++, $middle++);

        } elseif (empty($rightKey) || $array[$middle]->key == $rightKey) {
            if (empty($rightKey)) {
                $rightKey = $array[$middle]->key;
            }

            swapElements($array, $middle, $right--);
        } else {
            swapElements($array, $middle++, $left2++);
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
$result = dutchNationalFlagPartitionVariant2($index, $array);

printf('Partitioning the array %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;