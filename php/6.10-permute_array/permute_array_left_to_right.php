<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n^2) but the storage complexity is O(1)
 */

/**
 * Apply a permutation to an array in place and return the result.  This works by iterating through the original array
 * and at each iteration comparing all permutation positions in the sequence to the current iteration position.  If any
 * of them is smaller, nothing happens.  By ensuring that the current iteration position is the smallest, we enforce the
 * invariant that each permutation sequence is applied only once.
 *
 * If the current iteration position is the smallest, the permutation sequence is applied.  To apply the permutation
 * sequence, the element in the array at the current iterations position is stored.  Then it is put in the first
 * permutation position and the value in the first permutation position is stored.  This is continued until the
 * permutation sequence is completed.
 *
 * i.e.
 *
 * If the input array is [1, 2, 3] and the permutation is [2, 0, 1]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * $isMin = true
 * $j = 2
 *
 * <<< WHILE LOOP START >>>
 *
 * Iteration 1:
 * Is $j(2) != $i(0)? Yes
 * Is $j(2) < $i(0)? No
 * $j = 1
 *
 * Iteration 2:
 * Is $j(1) != $i(0)? Yes
 * Is $j(1) < $i(0)? No
 * $j = 0
 *
 * <<< WHILE LOOP TERMINATION: $i is the smallest >>>
 *
 * Is $isMin true? Yes
 * $a = $i(0)
 * $temp = $array[0](1)
 *
 * <<< DO WHILE LOOP START >>>
 *
 * Iteration 1:
 * $nexta = $permutation[0](2)
 * $nextTemp = $array[2](3)
 * $array = [1, 2, 1]
 * $a = $nexta(2)
 * $temp = $nextTemp(3)
 *
 * Iteration 2:
 * $nexta = $permuation[2](1)
 * $nextTemp = $array[1](2)
 * $array = [1, 3, 1]
 * $a = $nexta(1)
 * $temp = $nextTemp(2)
 *
 * Iteration 3:
 * $nexta = $permuation[1](0)
 * $nextTemp = $array[0](1)
 * $array = [2, 3, 1]
 * $a = $nexta(0)
 * $temp = $nextTemp(1)
 *
 * <<< DO WHILE LOOP TERMINATION: $a == $i >>>
 *
 * Iteration 2:
 * $i = 1
 * $isMin = true
 * $j = 0
 *
 * <<< WHILE LOOP START >>>
 *
 * Iteration 1:
 * Is $j(0) != $i(1)? Yes
 * Is $j(0) < $i(1)? Yes
 * $isMin = false
 *
 * <<< WHILE LOOP TERMINATION: $i is not the smallest >>>
 *
 * Is $isMin true? No
 *
 * Iteration 3:
 * $i = 2
 * $isMin = true
 * $j = 1
 *
 * <<< WHILE LOOP START >>>
 *
 * Iteration 1:
 * Is $j(1) != $i(2)? Yes
 * Is $j(1) < $i(2)? Yes
 * $isMin = false
 *
 * <<< WHILE LOOP TERMINATION: $i is not the smallest >>>
 *
 * Is $isMin true? No
 *
 * <<< LOOP TERMINATION: All elements of the input array have been iterated through >>>
 *
 * $array = [2, 3, 1]
 *
 * @param array $array
 * @param array $permutation
 * @return array
 * @throws \InvalidArgumentException
 * @throws \OutOfBoundsException
 */
function permuteArrayLeftToRight($array = [], $permutation = [])
{
    if (empty($array)) {
        throw new \InvalidArgumentException('$array may not be empty');
    }

    if (count($array) != count($permutation)) {
        throw new \InvalidArgumentException('$array and $permutation must match');
    }

    for ($i = 0; $i < count($array); $i++) {
        $isMin = true;
        $j = $permutation[$i];

        while ($j != $i) {
            if ($j < $i) {
                $isMin = false;
                break;
            }

            $j = $permutation[$j];
        }

        if ($isMin) {
            $a = $i;
            $temp = $array[$a];

            do {
                $nexta = $permutation[$a];
                $nextTemp = $array[$nexta];

                if (!isset($array[$nexta])) {
                    throw new \OutOfBoundsException('The index ' . $nexta . ' does not exist in the array.');
                }

                $array[$nexta] = $temp;
                $a = $nexta;
                $temp = $nextTemp;
            } while ($a != $i);
        }
    }

    return $array;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array to permute in json format: '));
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the permutation in json format: '));
$result = permuteArrayLeftToRight($array, $permutation);

printf(
    'The result of applying the %s permutation to %s is %s',
    json_encode($permutation),
    json_encode($array),
    json_encode($result)
);
print PHP_EOL;