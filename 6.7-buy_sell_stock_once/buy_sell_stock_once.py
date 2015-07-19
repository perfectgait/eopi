"""
Compute the maximum profit that can be made from one buy and one sell of a stock over a given number of days.

The time complexity is O(n)
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def maximum_profit(prices):
    """
    Find the maximum profit from buying and selling a stock once.  The way this works is by continuously finding the
    lowest price and then comparing the profit from selling that on the next day with the current maximum profit.
    """
    # @TODO Find what python highest int is
    minimum_price = 999999
    max_profit = 0

    for price in prices:
        max_profit_from_selling_today = price - minimum_price
        max_profit = max(max_profit, max_profit_from_selling_today)
        minimum_price = min(minimum_price, price)

    return max_profit


prices = [310, 315, 275, 295, 260, 270, 290, 230, 255, 250]
prices2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
prices3 = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1]
print 'The maximum profit to be made from the prices %s is: %d' % (prices, maximum_profit(prices))