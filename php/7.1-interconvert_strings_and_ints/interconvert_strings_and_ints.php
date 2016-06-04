<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(n)
 */

/**
 * Convert an integer to a string.  This works by going through each digit of the integer starting from the end and
 * appending it to the string.  Then the string is reversed and returned.  To grab the last digit of the integer take
 * the integer % 10.  Then divide the integer by 10 to shift it to the right by one.
 *
 * i.e.
 * If the $int is 576
 *
 * $string = ''
 * $isNegative = false
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $string = '6'
 * $int = 57
 *
 * Iteration 2:
 * $string = '67'
 * $int = 5
 *
 * Iteration 3:
 * $string = '675'
 * $int = 0
 *
 * <<< WHILE LOOP TERMINATION: $int <= 0 >>>
 *
 * The reversed string = '576'
 *
 * @param int $int
 * @return string
 */
function intToString($int)
{
    if (!is_int($int)) {
        throw new \InvalidArgumentException('$int must be an integer');
    }

    $string = '';
    $isNegative = false;

    if ($int < 0) {
        $int = -$int;
        $isNegative = true;
    }

    if ($int == 0) {
        return '0';
    }

    while ($int) {
        $string .= (string)($int % 10);
        $int = (int)($int / 10);
    }

    if ($isNegative) {
        $string .= '-';
    }

    return strrev($string);
}

/**
 * Convert a string to an integer.  This works by going through each character in the string starting from the front and
 * adding it to the integer.  Because it starts from the beginning of the string, each value added to the integer must
 * be correctly multiplied by the base (10) to the correct power.  This is done by multiplying the integer by 10 at each
 * iteration.  If the string is 3 characters long and the first character is a 5 it will be added to the integer and
 * multiplied by 10 twice.  The same as adding 5 * 10^2 to the integer which represents the hundreds place.
 *
 * i.e.
 * If the string is '576'
 *
 * $int = 0
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $int = 5
 *
 * Iteration 2:
 * $int = 57
 *
 * Iteration 3:
 * $int = 576
 *
 * <<< FOR LOOP TERMINATION: $i = 2 >>>
 *
 * $int = 576
 *
 * @param string $string
 * @return int
 */
function stringToInt($string)
{
    if (!is_string($string)) {
        throw new \InvalidArgumentException('$string must be a string');
    }

    if (strlen($string) <= 0) {
        return 0;
    }

    $int = 0;

    for ($i = ($string[0] == '-' ? 1 : 0); $i < strlen($string); $i++) {
        $int = 10 * $int + (int)$string[$i];
    }

    if ($string[0] == '-') {
        $int = -$int;
    }

    return $int;
}

$inputHelper = new InputHelper();
$choice = $inputHelper->readInputFromStdIn('Would you like to convert a string or integer? [s or i]: ');

if ($choice == 'i') {
    $from = (int)$inputHelper->readInputFromStdIn('Enter the integer you would like to convert to a string: ');
    $to = intToString($from);
} else {
    $from = (string)$inputHelper->readInputFromStdIn('Enter the string you would like to convert to an integer: ');
    $to = stringToInt($from);
}

printf('Converting the %s %d results in the %s %s', gettype($from), $from, gettype($to), $to);

print PHP_EOL;
