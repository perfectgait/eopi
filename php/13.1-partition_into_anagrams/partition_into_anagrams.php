<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(nm log m) because there are n calls to sort and n insertions into the hash table.  Sorting
 * the keys has time complexity O(nm log m).  The insertions have time complexity O(nm)
 */

/**
 * Partition an array of words into groups of anagrams.  This works by sorting each word and then inserting the unsorted
 * word into the hash table with the key being the sorted word.  Then each group of words at each key in the hash table
 * is checked.  If the group contains more than one entry, the group is added to the list of returned anagram groups.
 *
 * i.e.
 * If the input is "tire rite deal wheel lead"
 *
 * $sortedWordsToWords = []
 * $anagramGroups = []
 *
 * <<< FOR EACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $sortedWord = 'eirt'
 * $sortedWordsToWords = [
 *  'eirt' => [
 *      0 => 'tire'
 *  ]
 * ]
 *
 * Iteration 2:
 * $sortedWord = 'eirt'
 * $sortedWordsToWords = [
 *  'eirt' => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ]
 * ]
 *
 * Iteration 3:
 * $sortedWord = 'adel'
 * $sortedWordsToWords = [
 *  'eirt' => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ],
 *  'adel' => [
 *      0 => 'deal'
 *  ]
 * ]
 *
 * Iteration 4:
 * $sortedWord = 'eehlw'
 * $sortedWordsToWords = [
 *  'eirt' => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ],
 *  'adel' => [
 *      0 => 'deal'
 *  ],
 *  'eehlw' => [
 *      0 => 'wheel'
 *  ]
 * ]
 *
 * Iteration 5:
 * $sortedWord = 'adel'
 * $sortedWordsToWords = [
 *  'eirt' => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ],
 *  'adel' => [
 *      0 => 'deal',
 *      1 => 'lead'
 *  ],
 *  'eehlw' => [
 *      0 => 'wheel'
 *  ]
 * ]
 *
 * <<< FOR EACH LOOP TERMINATION: All words have been examined >>>
 *
 * <<< FOR EACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $sortedWord = 'eirt'
 * $words = [
 *  0 => 'tire',
 *  1 => 'rite'
 * ]
 * Is count($words) > 1? Yes
 * $anagramGroups = [
 *  0 => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ]
 * ]
 *
 * Iteration 2:
 * $sortedWord = 'adel'
 * $words = [
 *  0 => 'deal',
 *  1 => 'lead'
 * ]
 * Is count($words) > 1? Yes
 * $anagramGroups = [
 *  0 => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ],
 *  1 => [
 *      0 => 'deal',
 *      1 => 'lead'
 *  ]
 * ]
 *
 * Iteration 3:
 * $sortedWord = 'eehlw'
 * $words = [
 *  0 => 'wheel'
 * ]
 * Is count($words) > 1? No
 *
 * <<< FOR EACH LOOP TERMINATION: All sortedWordsToWords have been examined >>>
 *
 * return [
 *  0 => [
 *      0 => 'tire',
 *      1 => 'rite'
 *  ],
 *  1 => [
 *      0 => 'deal',
 *      1 => 'lead'
 *  ]
 * ]
 *
 * @param array $words
 * @return array
 */
function partitionIntoAnagramGroups($words = [])
{
    if (empty($words)) {
        return [];
    }

    $sortedWordsToWords = [];
    $anagramGroups = [];

    foreach ($words as $word) {
        // There is no built in string sort so we convert the string to an array, sort it and convert it back to a
        // string.
        $sortedWord = str_split($word);
        sort($sortedWord);
        $sortedWord = implode('', $sortedWord);
        $sortedWordsToWords[$sortedWord][] = $word;
    }

    foreach ($sortedWordsToWords as $sortedWord => $words) {
        // A group must have more than one entry
        if (count($words) > 1) {
            $anagramGroups[] = $words;
        }
    }

    return $anagramGroups;
}

$inputHelper = new InputHelper();
$words = explode(' ', $inputHelper->readInputFromStdIn('Enter the words separated by spaces: '));
$result = partitionIntoAnagramGroups($words);

printf('The groups of anagrams formed from %s are %s.', json_encode($words), json_encode($result));
print PHP_EOL;