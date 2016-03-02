<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the stream and the storage complexity is O(k) where k is the
 * $subsetSize
 */

/**
 * Sample online data.  This works by first storing the first $subsetSize characters.  After that each remaining
 * character is stored with $subsetSize/$elementNumber probability.  This is achieved by choosing a random number in the
 * range [0, $elementNumber].  If the random number is < $subsetSize, the element in the return array at the random
 * index is replaced with the character.
 *
 * i.e.
 * If the stream contains the characters "lsdjflf" and the $subsetSize = 3
 *
 * $result = []
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * $char = l
 * $result = [l]
 *
 * Iteration 2:
 * $i = 1
 * $char = s
 * $result = [l, s]
 *
 * Iteration 3:
 * $i = 2
 * $char = d
 * $result = [l, s, d]
 *
 * <<< FOR LOOP TERMINATION: $i = $subsetSize - 1 >>>
 *
 * $elementNumber = 3
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $char = j
 * $random = random number between 0 and $elementNumber(3) inclusive.  It picks 3
 * Is $random(3) < $subsetSize(3)? No
 * $result = [l, s, d]
 * $elementNumber = 4
 *
 * Iteration 2:
 * $char = f
 * $random = random number between 0 and $elementNumber(4) inclusive.  It picks 1
 * Is $random(1) < $subsetSize(3)? Yes
 * $result = [l, f, d]
 * $elementNumber = 5
 *
 * Iteration 3:
 * $char = l
 * $random = random number between 0 and $elementNumber(5) inclusive.  It picks 2
 * Is $random(2) < $subsetSize(3)? Yes
 * $result = [l, f, l]
 * $elementNumber = 6
 *
 * Iteration 4:
 * $char = f
 * $random = random number between 0 and $elementNumber(6) inclusive.  It picks 5
 * Is $random(5) < $subsetSize(3)? No
 * $result = [l, f, l]
 * $elementNumber = 7
 *
 * <<< WHILE LOOP TERMINATION: stream is empty >>>
 *
 * return [l, f, l]
 *
 * @param resource $fp
 * @param int $subsetSize
 * @return string
 */
function sampleOnlineData($fp, $subsetSize)
{
    if (!is_numeric($subsetSize) || $subsetSize < 1) {
        throw new \InvalidArgumentException('$subsetSize must be a positive integer');
    }

    $result = [];

    for ($i = 0; $i < $subsetSize && ($char = fgetc($fp)) !== false; $i++) {
        $result[] = $char;
    }

    $elementNumber = $subsetSize;

    while (($char = fgetc($fp)) !== false) {
        $random = mt_rand(0, $elementNumber++);

        if ($random < $subsetSize) {
            $result[$random] = $char;
        }
    }

    return $result;
}

$inputHelper = new InputHelper();
$path = $inputHelper->readInputFromStdIn('Enter the path to the stream file: ');
$subsetSize = $inputHelper->readInputFromStdIn('Enter the size of the subset to generate as a positive integer: ');
$fp = fopen($path, 'r');
$result = sampleOnlineData($fp, $subsetSize);
fclose($fp);

printf('A random sample of size %d is %s', $subsetSize, json_encode($result));
print PHP_EOL;