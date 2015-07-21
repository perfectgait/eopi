"""
Compute a sub-set of n elements where each sub-set is equally likely to occur.  This uses the numpy library
random_integer method to ensure that the random numbers are drawn from a uniform distribution.

The time complexity of compute_subset is O(n) assuming calls to the random number generator run in O(1) time.
"""

import numpy as np

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def compute_subset(array, length):
    """
    Compute a sub-set of the array of the specified length where all possible sub-sets are equally likely.
    """
    if length > len(array):
        length = len(array)

    for i in range(0, length):
        random_number = np.random.random_integers(i, len(array) - 1)
        array[i], array[random_number] = array[random_number], array[i]

    return array[0:length]


original_array = [1, 2, 3, 4, 5, 6, 7, 8, 9]
array = list(original_array)
length = 3
print 'Computed sub-set %s of length %d from the set %s' % (compute_subset(array, length), length, original_array)

original_array2 = [1, 1, 1, 1, 1]
array2 = list(original_array2)
length2 = 5
print 'Computed sub-set %s of length %d from the set %s' % (compute_subset(array2, length2), length2, original_array2)