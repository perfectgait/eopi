<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the storage complexity is O(1)
 */

/**
 * Randomly sample offline data.  This works by iterating from 0 to k - 1 and generating a random number in the range
 * (i, n - 1) (where n is the length of the input array).  The value at $data[random_number] and $data[i] are swapped.
 * Then the data array is spliced down to the size k and returned.
 *
 * i.e.
 * If the input array is [5,4,2,7,8,9,0,1] and $k = 3
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $random = random number between $i(0) and count($data) - 1(7) inclusive.  It picks 3
 * $temp = 7
 * $data = [7,4,2,5,8,9,0,1]
 *
 * Iteration 2:
 * $i = 1
 * $random = random number between $i(1) and count($data) - 1(7) inclusive.  It picks 5
 * $temp = 9
 * $data = [7,9,2,5,8,4,0,1]
 *
 * Iteration 3:
 * $i = 2
 * $random = random number between $i(2) and count($data) - 1(7) inclusive.  It picks 2
 * $temp = 2
 * $data = [7,9,2,5,8,4,0,1]
 *
 * <<< FOR LOOP TERMINATION: $i = $k >>>
 *
 * $data = [7,9,2,5,8,4,0,1]
 *
 * @param array $data
 * @param int $k
 * @return array
 * @throws \InvalidArgumentException
 */
function sampleOfflineData(array $data, $k)
{
    if (empty($data)) {
        throw new \InvalidArgumentException('$data cannot be empty');
    }

    if ($k > count($data)) {
        throw new \InvalidArgumentException('$k cannot be larger than the length of $data');
    }

    for ($i = 0; $i < $k; ++$i) {
        $random = mt_rand($i, count($data) - 1);
        $temp = $data[$random];
        $data[$random] = $data[$i];
        $data[$i] = $temp;
    }

    array_splice($data, $k);

    return $data;
}

$inputHelper = new InputHelper();
$data = json_decode($inputHelper->readInputFromStdIn('Enter the offline data in json format: '));
$k = json_decode($inputHelper->readInputFromStdIn('Enter the length of the random sample as an integer: '));
$result = sampleOfflineData($data, $k);

printf('A random sample from %s is %s', json_encode($data), json_encode($result));
print PHP_EOL;