<?php

require_once '../bootstrap.php';

use \EOPI\Helper\InputHelper;

/**
 * The running time is O(n) and the space complexity is O(m - l) where m is the count of the number of "a" characters
 * found and l is the count of the number of "b" characters found.  Because the function is given the original array and
 * it is modified in place it does not include the size of the original array in its space complexity.
 */

/**
 * Replace all "a"'s with "dd"'s and delete each "b" from the given array.  This works by first making a forward pass
 * through the input array looking for all instances of characters that are not "b."  If the character found is not a
 * "b" then that character gets written to the next place in the input array, starting from the left and going to the
 * right.
 * After the forward pass is done, the input array is re-sized, the current index is moved back one and the
 * write index is moved to the end of the array.
 * Finally, a backwards pass is made through the input array starting at the current index.  If the current character is
 * an "a," the character "d" is written to the write index and the character "d" is also written to the write index - 1.
 * If the current character is not an "a," the current character is simply written to the write index.
 *
 * i.e.
 * If the input array is [a, c, b, d]
 *
 * $s = [a, c, b, d]
 * $writeIndex = 0
 * $aCount = 0
 *
 * <<< FOREACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $c = a
 * Is $c(a) != b? Yes
 * $s = [a, c, b, d]
 * $writeIndex = 1
 * Is $c(a) == a? Yes
 * $aCount = 1
 *
 * Iteration 2:
 * $c = c
 * Is $c(c) != b? Yes
 * $s = [a, c, b, d]
 * $writeIndex = 2
 * Is $c(c) == a? No
 *
 * Iteration 3:
 * $c = b
 * Is $c(b) != b? No
 * Is $c(b) == a? No
 *
 * Iteration 4:
 * $c = d
 * Is $c(d) != b? Yes
 * $s = [a, c, d, d]
 * $writeIndex = 3
 * Is $c(d) == a? No
 *
 * <<< FOREACH LOOP TERMINATION: Array fully iterated >>>
 *
 * Re-size the array to $writeIndex(3) + $aCount(1) = 4
 * $s = [a, c, d, d]
 *
 * $currentIndex = $writeIndex(3) - 1 = 2
 * $writeIndex = $writeIndex(3) + $aCount(1) - 1 = 3
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * Is $s[$currentIndex(2)] == a? No
 * $s = [a, c, d, d]
 * $writeIndex = 2
 * $currentIndex = 1
 *
 * Iteration 2:
 * Is $s[$currentIndex(1)] == a? No
 * $s = [a, c, c, d]
 * $writeIndex = 1
 * $currentIndex = 0
 *
 * Iteration 3:
 * Is $s[$currentIndex(0)] == a? Yes
 * $s = [a, d, c, d]
 * $s = [d, d, c, d] -- $s is shown twice to illustrate what is happening, this is intentional
 * $writeIndex = 0
 * $currentIndex = -1
 *
 * <<< FOR LOOP TERMINATION: $currentIndex = -1 >>>
 *
 * $s = [d, d, c, d]
 *
 * @param \SplFixedArray $s
 * @return \SplFixedArray
 * @throws \Exception
 */
function replaceAndRemove($s)
{
    if (empty($s)) {
        throw new \Exception('The input string cannot be empty');
    }

    $writeIndex = 0;
    $aCount = 0;

    // On the forward pass, copy everything that is not a b to the left.
    foreach ($s as $c) {
        if ($c != 'b') {
            $s[$writeIndex++] = $c;
        }

        if ($c == 'a') {
            $aCount++;
        }
    }

    // Re-size the array for the new "dd" sequences.
    $s->setSize($writeIndex + $aCount);

    // On the backward pass, replace all "a" with "dd."
    $currentIndex = $writeIndex - 1;
    $writeIndex = $writeIndex + $aCount - 1;

    while ($currentIndex >= 0) {
        if ($s[$currentIndex] == 'a') {
            $s[$writeIndex--] = 'd';
            $s[$writeIndex--] = 'd';
        } else {
            $s[$writeIndex--] = $s[$currentIndex];
        }

        --$currentIndex;
    }

    return $s;
}

$inputHelper = new InputHelper();
$string = \SplFixedArray::fromArray(str_split($inputHelper->readInputFromStdIn('Enter the string: ')));
$originalString = clone $string;
$finalString = replaceAndRemove($string);

printf('%s was modified to become %s', implode('', $originalString->toArray()), implode($finalString->toArray()));
print PHP_EOL;