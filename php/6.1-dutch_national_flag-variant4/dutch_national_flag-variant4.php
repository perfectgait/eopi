<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n)
 */

/**
 * Partition an array of elements with keys that have a boolean value keeping the relative order of elements with true
 * keys the same.  Each section will contain elements with matching keys.  This works by keeping track of 3 sections of
 * a contiguous array.  The array is partitioned into, far right, unexplored and right sections.  As the loop iterates
 * through each element in the array in reverse order, the current elements key is looked at.  By iterating in reverse
 * order we can ensure that the elements with the true key are kept in the same relative position.
 *
 * If it is false, the current element is left in place.  Then the right index is decremented by one.
 *
 * If it is true, the current element is swapped with the element at the current right index.  Then the right index is
 * decremented by one.
 *
 * At the end of the iteration, the unexplored section is gone, leaving just a right and far right section.
 *
 * i.e.
 * If the array is [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 *
 * $right = 5
 * $farRight = 5
 *
 * Iteration 1:
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 * key is true
 * $right = 4
 * $farRight = 4
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 *
 * Iteration 2:
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 * key is false
 * $right = 3
 * $farRight = 4
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 *
 * Iteration 3:
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":true,"name":"Nikita"},{"key":false},{"key":true,"name":"Adil"}]
 * key is true
 * $right = 2
 * $farRight = 3
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":false},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 *
 * Iteration 4:
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":false},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 * key is false
 * $right = 1
 * $farRight = 3
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":false},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 *
 * Iteration 5:
 * [{"key":false},{"key":true,"name":"Matt"},{"key":false},{"key":false},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 * key is true
 * $right = 0
 * $farRight = 2
 * [{"key":false},{"key":false},{"key":false},{"key":true,"name":"Matt"},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 *
 * Iteration 6:
 * [{"key":false},{"key":false},{"key":false},{"key":true,"name":"Matt"},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 * key is false
 * $right = -1
 * $farRight = 2
 * [{"key":false},{"key":false},{"key":false},{"key":true,"name":"Matt"},{"key":true,"name":"Nikita"},{"key":true,"name":"Adil"}]
 *
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartitionVariant4($array)
{
    $right = count($array) - 1;
    $farRight = $right;

    while ($right >= 0) {
        if ($array[$right]->key === false) {
            $right--;
        } else {
            swapElements($array, $right--, $farRight--);
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
$result = dutchNationalFlagPartitionVariant4($array);

printf('Partitioning the array %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;