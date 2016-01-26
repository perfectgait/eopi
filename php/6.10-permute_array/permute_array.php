<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the storage complexity is O(n) where n is the size of the input array.  The storage
 * complexity is derived from the fact that we are using the sign bit of the permutation array values to determine if
 * they have been visited.
 */

/**
 * Apply a permutation to an array in place and return the result.  This works by iterating through the array and at
 * each step checking the corresponding permutation.  If the permutation is positive that means it has not been
 * visited and something should happen.  The value in the array where the permutation points is stored temporarily
 * and overwritten with the current value in the array at this iteration.  The current permutation value has its sign
 * bit flipped (by subtracting the length of the permutation array) indicating it has been visited.  This continues
 * until the value in the permutation array at the index of the current permutation = the value of the current
 * iteration, meaning a cycle has occurred (i.e. if the permutation array is [2, 0, 1] and the current iteration is 0,
 * 2 will be the next permutation checked).
 *
 * i.e.
 *
 * If the input array is [1, 2, 3] and the permutation is [2, 0, 1]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * $a = 0
 * $temp = 1
 * Is $permutation[0](2) >= 0? Yes
 * <<< DO WHILE START >>>
 *
 * Iteration 1:
 * $nexta = 2
 * $nextTemp = 3
 * $array = [1, 2, 1]
 * $permuation = [-1, 0, 1]
 * $a = 2
 * $temp = 3
 *
 * Iteration 2:
 * $nexta = 1
 * $nextTemp = 2
 * $array = [1, 3, 1]
 * $permutation = [-1, 0, -2]
 * $a = 1
 * $temp = 2
 *
 * Iteration 3:
 * $nexta = 0
 * $nextTemp = 1
 * $array = [2, 3, 1]
 * $permutation = [-1, -3, -2]
 * $a = 0
 * $temp = 1
 *
 * <<< DO WHILE TERMINATION: $a == $i >>>
 *
 * Iteration 2:
 * $i = 1
 * $a = 1
 * $temp = 3
 * Is $permutation[1](-3) >= 0? No
 *
 * Iteration 3:
 * $i = 2
 * $a = 2
 * $temp = 1
 * Is $permutation[2](-2) >= 0? No
 *
 * <<< LOOP TERMINATION >>>
 *
 * <<< LOOP THROUGH $permutation and flip the sign bit back >>>
 *
 * $permutation = [2, 0, 1]
 * $array = [2, 3, 1]
 *
 * @param array $array
 * @param array $permutation
 * @return array
 * @throws \InvalidArgumentException
 * @throws \OutOfBoundsException
 */
function permuteArray($array = [], $permutation = [])
{
    if (empty($array)) {
        throw new \InvalidArgumentException('$array may not be empty');
    }

    if (count($array) != count($permutation)) {
        throw new \InvalidArgumentException('$array and $permutation must match');
    }

    for ($i = 0; $i < count($array); $i++) {
        $a = $i;
        $temp = $array[$a];

        if ($permutation[$i] >= 0) {
            do {
                $nexta = $permutation[$a];
                $nextTemp = $array[$nexta];

                if (!isset($array[$nexta])) {
                    throw new \OutOfBoundsException('The index ' . $nexta . ' does not exist in the array.');
                }

                $array[$nexta] = $temp;
                $permutation[$a] -= count($permutation);
                $a = $nexta;
                $temp = $nextTemp;
            } while ($a != $i);
        }
    }

    for ($j = 0; $j < count($permutation); $j++) {
        $permutation[$j] += count($permutation);
    }

    return $array;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array to permute in json format: '));
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the permutation in json format: '));
$result = permuteArray($array, $permutation);

printf(
    'The result of applying the %s permutation to %s is %s',
    json_encode($permutation),
    json_encode($array),
    json_encode($result)
);
print PHP_EOL;