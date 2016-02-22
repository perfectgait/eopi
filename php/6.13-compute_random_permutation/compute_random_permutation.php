<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the storage complexity is O(1)
 */

/**
 * Compute a random permutation of the input array.  This works by iteration from 0 to n - 1 a generating a random
 * number in the range (i, n - 1) (where n is the length of the input array).  The value at $data[random_number] and
 * $data[i] are swapped.
 *
 * i.e.
 * If the input array is [1,2,3,4,5]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $random = random number between $i(0) and count($data) - 1(4) inclusive.  It picks 3
 * $temp = 1
 * $array = [4,2,3,1,5]
 *
 * Iteration 2:
 * $i = 1
 * $random = random number between $i(1) and count($data) - 1(4) inclusive.  It picks 2
 * $temp = 2
 * $array = [4,3,2,1,5]
 *
 * Iteration 3:
 * $i = 2
 * $random = random number between $i(2) and count($data) - 1(4) inclusive.  It picks 4
 * $temp = 2
 * $array = [4,3,5,1,2]
 *
 * Iteration 4:
 * $i = 3
 * $random = random number between $i(3) and count($data) - 1(4) inclusive.  It picks 3
 * $temp = 2
 * $array = [4,3,5,1,2]
 *
 * <<< FOR LOOP TERMINATION: $i = count($array) - 1 >>>
 *
 * $array = [4,3,5,1,2]
 *
 * @param array $array
 * @return array
 * @throws \InvalidArgumentException
 */
function computeRandomPermutation(array $array)
{
    if (empty($array)) {
        throw new \InvalidArgumentException('$array cannot be empty');
    }

    if (count($array) === 1) {
        return $array;
    }

    for ($i = 0; $i < count($array) - 1; $i++) {
        $random = mt_rand($i, count($array) - 1);
        $temp = $array[$i];
        $array[$i] = $array[$random];
        $array[$random] = $temp;
    }

    return $array;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array in json format: '));
$result = computeRandomPermutation($array);

printf('A random permutation of %s is %s', json_encode($array), json_encode($result));
print PHP_EOL;