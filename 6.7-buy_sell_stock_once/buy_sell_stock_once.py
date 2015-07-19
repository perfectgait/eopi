"""
Compute the maximum profit that can be made from one buy and one sell of a stock over a given number of days.

The time complexity of maximum_profit is O(n)
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def maximum_profit(prices):
    """
    Find the maximum profit from buying and selling a stock once.  The way this works is by continuously finding the
    lowest price and then comparing the profit from selling that on the next day with the current maximum profit.
    """
    # This could be set to sys.maxint however that would still leave an edge case where the prices were extremely high.
    minimum_price = None
    max_profit = 0

    for price in prices:
        # Initial iteration
        if minimum_price is None:
            minimum_price = price
        else:
            max_profit_from_selling_today = price - minimum_price
            max_profit = max(max_profit, max_profit_from_selling_today)
            minimum_price = min(minimum_price, price)

    return max_profit


def longest_subarray(integers):
    """
    Find the length of the longest sub-array where all entries are equal

    i.e. [1,2,3,4,4,4,5,5,6,7,8,9] would be 3
    """
    current = 0
    longest = 0
    current_value = None

    for integer in integers:
        if current_value is None or current_value != integer:
            if current > longest:
                longest = current

            current = 0
            current_value = integer

        current += 1

    if current > longest:
        longest = current

    return longest


prices = [310, 315, 275, 295, 260, 270, 290, 230, 255, 250]
prices2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
prices3 = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1]
print 'The maximum profit to be made from the prices %s is: %d' % (prices, maximum_profit(prices))

integer_array = [1, 2, 3, 4, 4, 4, 5, 5, 6, 7, 8, 9]
integer_array2 = [1, 2, 2, 2, 2, 2, 1, 1, 1, 1]
integer_array3 = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1]
integer_array4 = []
print 'The maximum sub-array where all entries are equal for the integers %s is: %d'\
      % (integer_array4, longest_subarray(integer_array4))