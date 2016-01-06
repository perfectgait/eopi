<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(n) where n is the length of the input array
 */

/**
 * Find the maximum profit from selling a stock twice over a period of days.  This works by first calculating the
 * maximum profit for each day and storing that in an array (See 6.7-buy_and_sell_stock_once readme for a detailed
 * explanation of this calculation).  Once all of the maximum profits have been calculated a reverse iteration of prices
 * is performed.  In the reverse iteration the maximum profit is calculated by comparing the current maximum profit to
 * the maximum price minus the cost of buying the stock on the current day plus the maximum profit that could have been
 * made on the previous day.
 *
 * i.e.
 *
 * If the array of prices is [310, 315, 275, 295, 260, 270, 290, 230, 255, 250]
 *
 * Ignore calculating the first profits
 *
 * $firstProfits = [0, 5, 5, 20, 20, 20, 30, 30, 30, 30] (See 6.7-buy_and_sell_stock_once readme for a detailed explanation of this calculation)
 * $maximumProfit = 30
 * $maximumPrice = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $j = 9
 * Is $prices[$j](250) > $maximumPrice(0)? Yes
 * $maximumPrice = 250
 * Is $maximumPrice(250) - $prices[$j](250) + $firstProfits[$j - 1](30) = 30 > $maximumProfit(30)? No
 * $maximumProfit = 30
 *
 * Iteration 2:
 * $j = 8
 * Is $prices[$j](255) > $maximumPrice(250)? Yes
 * $maximumPrice = 255
 * Is $maximumPrice(255) - $prices[$j](255) + $firstProfits[$j - 1](30) = 30 > $maximumProfit(30)? No
 * $maximumProfit = 30
 *
 * Iteration 3:
 * $j = 7
 * Is $prices[$j](230) > $maximumPrice(255)? No
 * $maximumPrice = 255
 * Is $maximumPrice(255) - $prices[$j](230) + $firstProfits[$j - 1](30) = 55 > $maximumProfit(30)? Yes
 * $maximumProfit = 55
 *
 * Iteration 4:
 * $j = 6
 * Is $prices[$j](290) > $maximumPrice(255)? Yes
 * $maximumPrice = 290
 * Is $maximumPrice(290) - $prices[$j](290) + $firstProfits[$j - 1](20) = 20 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * Iteration 5:
 * $j = 5
 * Is $prices[$j](270) > $maximumPrice(290)? No
 * $maximumPrice = 290
 * Is $maximumPrice(290) - $prices[$j](270) + $firstProfits[$j - 1](20) = 40 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * Iteration 6:
 * $j = 4
 * Is $prices[$j](260) > $maximumPrice(290)? No
 * $maximumPrice = 290
 * Is $maximumPrice(290) - $prices[$j](260) + $firstProfits[$j - 1](20) = 50 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * Iteration 7:
 * $j = 3
 * Is $prices[$j](295) > $maximumPrice(290)? Yes
 * $maximumPrice = 295
 * Is $maximumPrice(295) - $prices[$j](295) + $firstProfits[$j - 1](5) = 5 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * Iteration 8:
 * $j = 2
 * Is $prices[$j](275) > $maximumPrice(295)? No
 * $maximumPrice = 295
 * Is $maximumPrice(295) - $prices[$j](275) + $firstProfits[$j - 1](5) = 25 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * Iteration 9:
 * $j = 1
 * Is $prices[$j](315) > $maximumPrice(295)? Yes
 * $maximumPrice = 315
 * Is $maximumPrice(315) - $prices[$j](315) + $firstProfits[$j - 1](0) = 0 > $maximumProfit(55)? No
 * $maximumProfit = 55
 *
 * <<< LOOP TERMINATION: all prices have been iterated through >>>
 *
 * The maximum profit is 55
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

    $firstProfits = [];
    $maximumProfit = 0;
    $minimumPrice = PHP_INT_MAX;

    for ($i = 0; $i < count($prices); $i++) {
        if (!is_numeric($prices[$i]) || $prices[$i] < 0) {
            throw new \InvalidArgumentException('Not all $prices are non-negative, real numbers');
        }

        $minimumPrice = min($minimumPrice, $prices[$i]);
        $maximumProfit = max($maximumProfit, $prices[$i] - $minimumPrice);
        $firstProfits[$i] = $maximumProfit;
    }

    $maximumPrice = 0;

    for ($j = count($prices) - 1; $j > 0; $j--) {
        $maximumPrice = max($maximumPrice, $prices[$j]);
        // Calculate the maximum profit by comparing the current maximum profit to the highest price seen so far minus
        // the cost of buying today plus the maximum profit that can be made from the previous day.
        $maximumProfit = max($maximumProfit, $maximumPrice - $prices[$j] + $firstProfits[$j - 1]);
    }

    return (int)$maximumProfit;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of non-negative, real numbers in json format: '));
$result = findMaximumProfit($array);

printf('The maximum profit of buying a single stock twice from %s is %d', json_encode($array), $result);
print PHP_EOL;