"""
Compute the spiral order of a 2-D array

The time complexity of compute_sprial_order is O(n^2)
"""

import math

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def compute_sprial_order(array):
    """
    Compute the spiral order of an nxn matrix represented as a 2-D array.  This only loops through the length of the
    array / 2 because anything beyond that will have already been computed.  i.e. if the length of the array is 3 then
    it would stop at iteration 1 because if we continued the for loops of the compute_matrix_clockwise function would do
    nothing.

    i.e.
    The sprial order of
    [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ]
    is [1, 2, 3, 6, 9, 8, 7, 4, 5]
    """
    result = []

    for offset in range(0, int(math.ceil(len(array) * .5))):
        compute_matrix_clockwise(array, offset, result)

    return result

def compute_matrix_clockwise(array, offset, result):
    """
    Compute the spiral order of the matrix in clockwise order.  The way this works is as follows:

    1. Add the first n-1 elements from the first row to the results list.  This happens in the first for loop.
    2. Add the first n-1 elements from the last column to the results list.  This happens in the second for loop.
    3. Add the last n-1 elements in reverse order from the last row to the results list.  This happens in the third for
       loop.
    4. Add the last n-1 elements in reverse order from the first column to the results list.  This happens in the fourth
       for loop.
    5. (Optional) If the length of the array is odd we handle the edge case where there is a middle element.

    If you were to draw a square composed of 9 smaller squares and trace your finger around the smaller squares in a
    clockwise manner starting at the upper left square and not touching any square twice it would represent what is
    happening.
    """

    # Add the middle element if the length of the array is odd
    if offset == len(array) - offset - 1:
        result.append(array[offset][offset])
        return

    # Add entries from the nth row of the array to the result
    for j in range(offset, len(array) - offset - 1):
        result.append(array[offset][j])

    # Add entries from the last column of the array to the result
    for i in range(offset, len(array) - offset - 1):
        result.append(array[i][len(array) - offset - 1])

    # Add entries from the last row of the array to the result
    for j in range(len(array) - offset - 1, offset, -1):
        result.append(array[len(array) - offset - 1][j])

    # Add entries from the nth column of the array to the result
    for i in range(len(array) - offset - 1, offset, -1):
        result.append(array[i][offset])

array = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]
array2 = [
    [1, 2],
    [3, 4]
]
array3 = [
    [1, 2, 3, 4, 5],
    [6, 7, 8, 9, 10],
    [11, 12, 13, 14, 15],
    [16, 17, 18, 19, 20],
    [21, 22, 23, 24, 25]
]
print 'The spiral order of %s is %s' % (array3, compute_sprial_order(array3))