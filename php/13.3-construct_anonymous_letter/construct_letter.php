<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The running time is O(m + n) where m is the length of $letterText and n is the length of $magazineText and the space
 * complexity is O(l) where l is the number of distinct characters in $letterText.
 */

/**
 * Determine if letter text can be constructed using the characters found in magazine text.  This works by going through
 * all the characters in the letter text and counting them using a hash table.  Each key in the hash table is a
 * character and the value is an integer representing the number of appearances in the string of that character.  After
 * the characters have been counted each character in the magazine text is looked at.  Each character is checked to see
 * if it's a key in the hash table.  If it is, the value at that key is subtracted by one.  If the value at that key
 * falls to 0, that key in the hash table is removed.  After looking at all characters in the magazine text the hash
 * table is checked to see if it's empty.  If it is, the letter can be constructed because no characters remain.
 *
 * i.e.
 * If the $letterText is abcde and the $magazineText is edcba
 *
 * $letters = []
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 * Is $letters[a] set? No
 * $letters[a] = 0;
 * $letters = [
 *      a => 1
 * ]
 *
 * Iteration 2:
 * $i = 1
 * Is $letters[b] set? No
 * $letters[b] = 0;
 * $letters = [
 *      a => 1,
 *      b => 1
 * ]
 *
 * Iteration 3:
 * $i = 2
 * Is $letters[c] set? No
 * $letters[c] = 0;
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1
 * ]
 *
 * Iteration 4:
 * $i = 3
 * Is $letters[d] set? No
 * $letters[d] = 0;
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1
 *      d => 1
 * ]
 *
 * Iteration 5:
 * $i = 4
 * Is $letters[e] set? No
 * $letters[e] = 0;
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1,
 *      d => 1,
 *      e => 1
 * ]
 *
 * <<< FOR LOOP TERMINATION: $i = strlen($letterText) >>>
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $j = 0
 * Is $letters[e] set? Yes
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1,
 *      d => 1,
 *      e => 0
 * ]
 * Is $letters[e] === 0? Yes
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1,
 *      d => 1
 * ]
 * Is $letters empty? No
 *
 * Iteration 2:
 * $j = 1
 * Is $letters[d] set? Yes
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1,
 *      d => 0
 * ]
 * Is $letters[d] === 0? Yes
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 1
 * ]
 * Is $letters empty? No
 *
 * Iteration 3:
 * $j = 2
 * Is $letters[c] set? Yes
 * $letters = [
 *      a => 1,
 *      b => 1,
 *      c => 0
 * ]
 * Is $letters[c] === 0? yes
 * $letters = [
 *      a => 1,
 *      b => 1
 * ]
 * Is $letters empty? No
 *
 * Iteration 4:
 * $j = 3
 * Is $letters[b] set? Yes
 * $letters = [
 *      a => 1,
 *      b => 0
 * ]
 * Is $letters[b] === 0? Yes
 * $letters = [
 *      a => 1
 * ]
 * Is $letters empty? No
 *
 * Iteration 5:
 * $j = 4
 * Is $letters[a] set? Yes
 * $letters = [
 *      a => 0
 * ]
 * Is $letters[a] === 0? Yes
 * $letters = []
 * Is $letters empty? Yes
 * return true
 *
 * <<< FOR LOOP TERMINATION: return >>>
 *
 * @param string $letterText
 * @param string $magazineText
 * @return bool
 */
function letterCanBeConstructed($letterText, $magazineText)
{
    if (strlen($letterText) === 0) {
        throw new \InvalidArgumentException('$letterText cannot be empty');
    }

    if (strlen($magazineText) < strlen($letterText)) {
        return false;
    }

    $letters = [];

    for ($i = 0; $i < strlen($letterText); $i++) {
        if (!isset($letters[$letterText[$i]])) {
            $letters[$letterText[$i]] = 0;
        }

        $letters[$letterText[$i]]++;
    }

    for ($j = 0; $j < strlen($magazineText); $j++) {
        if (isset($letters[$magazineText[$j]])) {
            $letters[$magazineText[$j]]--;

            if ($letters[$magazineText[$j]] === 0) {
                unset($letters[$magazineText[$j]]);
            }
        }

        if (empty($letters)) {
            return true;
        }
    }

    return empty($letters);
}

$inputHelper = new InputHelper();
$letterText = $inputHelper->readInputFromStdIn('Enter the letter text: ');
$magazineText = $inputHelper->readInputFromStdIn('Enter the magazine text: ');
$result = letterCanBeConstructed($letterText, $magazineText);

if ($result) {
    print 'The anonymous letter can be constructed from the magazine text.' . PHP_EOL;
} else {
    print 'The anonymous letter cannot be constructed from the magazine text.' . PHP_EOL;
}