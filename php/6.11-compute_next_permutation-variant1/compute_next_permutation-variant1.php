<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array and the storage complexity is O(n) where n is
 * the count of the items in the input array.
 */

/**
 * Compute the k-th permutation of the passed in identity permutation.  To understand how this works first we must
 * illustrate how permutations are ordered using dictionary ordering.  We will use the identity permutation [0,1,2] to
 * demonstrate.  In this case there are 3!(3 * 2 * 1) = 6 permutations.  They are as follows using dictionary ordering:
 * [0,1,2]
 * [0,2,1]
 * [1,0,2]
 * [1,2,0]
 * [2,0,1]
 * [2,1,0]
 * As we can see, when starting with the empty set [], we have 3! available choices, corresponding to the first value in
 * each permutation.  Once the first choice is made we have 2! available choices.  After the second choice is made we
 * have 1! available choices so we are done.
 * At each level, the choices are ordered in ascending order.  The outer level has one possibility:
 * [0,
 *  0,
 *  1,
 *  1,
 *  2,
 *  2]
 * The second level has 3 possibilities:
 * [1,  [0,  [0,
 *  2]   2]   1]
 * The third level has 6 possibilities with one value each, they are all trivially sorted in ascending order.  We also
 * need to understand that the number of permutations is n! (n * n-1 * n-2, ... * 1).  n-1! is equal to n!/n.
 *
 * Now we can calculate the k-th permutation by finding the values assigned at each index.  We will find the value at
 * an index by (k/total choices * unique choices).  Because k/total choices may not be a whole number and because we are
 * dealing with 0-based indexes we end up with (ceiling(k/total choices * unique choices) - 1). This works because of
 * the fact that at each level the choices are sorted in ascending order.  At any level if k + 1 is > than the total
 * choices, total choices is subtracted from k until k + 1 is < the total choices.
 *
 * i.e.
 * If the identity permutation is [0,1,2,3] and k is 19
 *
 * $permutations = 24
 * $writeIndex = 0
 * $range = [0,1,2,3]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 4
 * $k = 19
 * is $range[3](3) != $permutation[0](0)? Yes
 * $permutation = [3,1,2,3]
 * $range = [0,1,2]
 * $writeIndex = 1
 * $permutations = 6
 *
 * Iteration 2:
 * $j = 3
 * $k = 1
 * is $range[0](0) != $permutation[1](1)? Yes
 * $permutation = [3,0,2,3]
 * $range = [1,2]
 * $writeIndex = 2
 * $permutations = 2
 *
 * Iteration 3:
 * $j = 2
 * $k = 1
 * is $range[1](2) != $permutation[2](2)? No
 * $range = [1]
 * $writeIndex = 3
 * $permutations = 1
 *
 * <<< FOR LOOP TERMINATION: $j = 1 >>>
 *
 * $range[0] is written to $permutation[$writeIndex]
 * $permutation = [3,0,2,1]
 *
 * @param array $permutation
 * @param int $k
 * @return array
 * @throws \InvalidArgumentException
 */
function computeKthPermutation(array $permutation, $k)
{
    if (empty($permutation)) {
        throw new \InvalidArgumentException('$permutation may not be empty');
    }

    if (!is_numeric($k) || $k < 0) {
        throw new \InvalidArgumentException('$k must be >= 0');
    }

    $permutations = count($permutation);

    // Don't rely on gmp_fact being present
    for ($i = 2; $i < count($permutation); $i++) {
        $permutations *= $i;
    }

    if ($k + 1 > $permutations) {
        throw new \InvalidArgumentException('There are only ' . $permutations . ' permutations of ' . json_encode($permutation));
    }

    $writeIndex = 0;
    $range = range(0, count($permutation) - 1);

    for ($j = count($permutation); $j > 1; $j--) {
        // Ensure that $k points to the correct permutation block
        while ($k + 1 > $permutations) {
            $k -= $permutations;
        }

        if ($range[(int)ceil(($k + 1) / $permutations * $j) - 1] != $permutation[$writeIndex]) {
            $permutation[$writeIndex] = $range[(int)ceil(($k + 1) / $permutations * $j) - 1];
        }

        array_splice($range, (int)ceil(($k + 1) / $permutations * $j) - 1, 1);
        $writeIndex++;
        $permutations /= $j;
    }

    $permutation[$writeIndex] = $range[0];

    return $permutation;
}

$inputHelper = new InputHelper();
$permutation = json_decode($inputHelper->readInputFromStdIn('Enter the identity permutation in json format: '));
$k = $inputHelper->readInputFromStdIn('Enter k as an integer >= 0: ');
$result = computeKthPermutation($permutation, $k);

printf(
    'The k-th permutation of %s is %s',
    json_encode($permutation),
    json_encode($result)
);
print PHP_EOL;