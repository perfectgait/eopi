<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the array A
 */

/**
 * Increment a big integer.  This works by first adding 1 to the last element in the array.  Then looping through the
 * array as long as there are elements in the array equal to 10.  When an element is found that is equal to 10, that
 * index in the array is set to 0 and 1 is added to the element to the left.  When the loop is done the first element is
 * checked to see if it is equal to 10.  If it is, it is set to 0 and an element is added to the front of the array with
 * a value of 1.
 *
 * i.e.
 * If the array is [1,2,9]
 *
 * A = [1,2,10]
 * $i = 2
 *
 * Iteration 1:
 * The element is 10
 * A = [1,3,0]
 * $i = 1
 *
 * Iteration 2:
 * The element is not 10 so the loop stops
 *
 * The element at index 0 is not 10
 *
 * A = [1,3,0]
 *
 *
 * If the array is [9,9,9]
 *
 * A = [9,9,10]
 * $i = 2
 *
 * Iteration 1:
 * The element is 10
 * A = [9,10,0]
 * $i = 1
 *
 * Iteration 2:
 * The element is 10
 * A = [10,0,0]
 * $i = 0
 *
 * The element at index 0 is 10
 * A = [1,0,0,0]
 *
 * @param array $array
 * @return array
 */
function incrementBigInteger(array $array)
{
    $array[count($array) - 1]++;

    for ($i = count($array) - 1; $i > 0 && $array[$i] == 10; $i--) {
        $array[$i] = 0;
        ++$array[$i - 1];
    }

    if ($array[0] == 10) {
        $array[0] = 0;
        array_unshift($array, 1);
    }

    return $array;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of integers in json format: '));
$result = incrementBigInteger($array);

printf('Adding 1 to %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;