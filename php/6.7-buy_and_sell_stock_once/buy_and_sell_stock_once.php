<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the size of the input
 */

/**
 * Find the maximum profit that can be made by buying and selling a stock once from the array of prices.  This works by
 * iterating through all of the prices and finding the maximum profit for that day.  If that value is the maximum profit
 * overall it is remembered.  If the price for that day is the lowest, it is also remembered.  After iterating through
 * all of the days, all of the days have been compared and the maximum profit is found.
 *
 * i.e.
 *
 * If the array of prices is [310, 315, 275, 295, 260, 270, 290, 230, 255, 250]
 *
 * $maximumProfit = 0
 * $minimumPrice = PHP_INT_MAX (usually 2147483647) @see http://php.net/manual/en/reserved.constants.php
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $price = 310
 * $maximumProfitForToday = -2147483337
 * $maximumProfit = 0
 * $minimumPrice = 310
 *
 * Iteration 2:
 * $price = 315
 * $maximumProfitForToday = 5
 * $maximumProfit = 5
 * $minimumPrice = 310
 *
 * Iteration 3:
 * $price = 275
 * $maximumProfitForToday = -35
 * $maximumProfit = 5
 * $minimumPrice = 275
 *
 * Iteration 4:
 * $price = 295
 * $maximumProfitForToday = 20
 * $maximumProfit = 20
 * $minimumPrice = 275
 *
 * Iteration 5:
 * $price = 260
 * $maximumProfitForToday = -15
 * $maximumProfit = 20
 * $minimumPrice = 260
 *
 * Iteration 6:
 * $price = 270
 * $maximumProfitForToday = 10
 * $maximumProfit = 20
 * $minimumPrice = 260
 *
 * Iteration 7:
 * $price = 290
 * $maximumProfitForToday = 30
 * $maximumProfit = 30
 * $minimumPrice = 260
 *
 * Iteration 8:
 * $price = 230
 * $maximumProfitForToday = -30
 * $maximumProfit = 30
 * $minimumPrice = 230
 *
 * Iteration 9:
 * $price = 255
 * $maximumProfitForToday = 25
 * $maximumProfit = 30
 * $minimumPrice = 230
 *
 * Iteration 10:
 * $price = 250
 * $maximumProfitForToday = 20
 * $maximumProfit = 30
 * $minimumPrice = 230
 *
 * <<< LOOP TERMINATION: all prices have been iterated through >>>
 *
 * The maximum profit is 30
 *
 * @param array $prices
 * @return int
 * @throws \InvalidArgumentException
 */
function findMaximumProfit(array $prices = [])
{
    if (empty($prices)) {
        throw new \InvalidArgumentException('$prices is empty');
    }

    $maximumProfit = 0;
    $minimumPrice = PHP_INT_MAX;

    foreach ($prices as $price) {
        if (!is_numeric($price) || $price < 0) {
            throw new \InvalidArgumentException('Not all $prices are non-negative, real numbers');
        }

        $maximumProfitForToday = $price - $minimumPrice;
        $maximumProfit = max($maximumProfitForToday, $maximumProfit);
        $minimumPrice = min($price, $minimumPrice);
    }

    return (int)$maximumProfit;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of non-negative, real numbers in json format: '));
$result = findMaximumProfit($array);

printf('The maximum profit of buying a single stock from %s is %d', json_encode($array), $result);
print PHP_EOL;