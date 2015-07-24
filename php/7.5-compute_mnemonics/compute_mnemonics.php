<?php
/**
 * Compute the mnemonics for a given phone number.
 *
 * The time complexity of compute_mnemonics is O(4^n*n)
 */

/**
 * Compute the mnemonics for a phone number
 *
 * @param string $phoneNumber
 * @param int $digit
 * @param string $partialMnemonic
 * @param array $mnemonics
 */
function compute_mnemonics($phoneNumber, $digit, &$partialMnemonic, &$mnemonics)
{
    static $characters = [
        ['0'],
        ['1'],
        ['A', 'B', 'C'],
        ['D', 'E', 'F'],
        ['G', 'H', 'I'],
        ['J', 'K', 'L'],
        ['M', 'N', 'O'],
        ['P', 'Q', 'R', 'S'],
        ['T', 'U', 'V'],
        ['W', 'X', 'Y', 'Z']
    ];

    if ($digit == strlen($phoneNumber)) {
        // In the base case add the complete mnemonic to the array of mnemonics
        $mnemonics[] = $partialMnemonic;
    } else {
        // For each character that maps to this number, determine the mnemonics
        foreach ($characters[$digit] as $char) {
            $partialMnemonic[$digit] = $char;
            compute_mnemonics($phoneNumber, $digit + 1, $partialMnemonic, $mnemonics);
        }
    }
}

$mnemonics = [];
$phoneNumber = '6157689629';
$partialMnemonic = str_pad('', strlen($phoneNumber), 0);
compute_mnemonics($phoneNumber, 0, $partialMnemonic, $mnemonics);

var_dump($mnemonics);

$mnemonics2 = [];
$phoneNumber2 = '';
$partialMnemonic2 = str_pad('', strlen($phoneNumber2), 0);
compute_mnemonics($phoneNumber2, 0, $partialMnemonic2, $mnemonics2);

var_dump($mnemonics2);