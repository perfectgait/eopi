<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the number of characters in the string
 */

/**
 * Test if a string is a palindrome.  Non alphanumeric characters are ignored.  This works by iterating from each end of
 * the string and comparing the characters at each end.  If they do not match, the string is not a palindrome.
 *
 * @param string $string
 * @return bool
 */
function isPalindrome($string)
{
    $i = 0;
    $j = strlen($string) - 1;

    while ($i < $j) {
        while (!ctype_alnum($string[$i]) && $i < $j) {
            $i++;
        }

        while (!ctype_alnum($string[$j]) && $i < $j) {
            $j--;
        }

        if (strtolower($string[$i]) != strtolower($string[$j])) {
            return false;
        }

        $i++;
        $j--;
    }

    return true;
}

$inputHelper = new InputHelper();
$string = $inputHelper->readInputFromStdIn('Enter the string to test: ');
$result = isPalindrome($string);

if ($result === true) {
    printf('The string %s is a palindrome', $string);
} else {
    printf('The string %s is not a palindrome', $string);
}

print PHP_EOL;