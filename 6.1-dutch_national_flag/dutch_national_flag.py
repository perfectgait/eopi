"""
Solve the dutch national flag problem where an array is partitioned into elements less than the pivot, equal to the
pivot and greater than the pivot

The time complexity is O(n)
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def dutch_national_flag(array, pivot):
    """
    Handle the dutch national flag problem by partitioning an array around a pivot such that all of the elements less
    than the pivot come first, then the elements equal to the pivot then the elements greater than the pivot.
    """
    smaller = 0
    equal = 0
    larger = len(array) - 1
    pivot_element = array[pivot]

    while equal <= larger:
        if array[equal] < pivot_element:
            swap_elements(array, equal, smaller)
            equal += 1
            smaller += 1
        elif array[equal] == pivot_element:
            equal += 1
        else:
            swap_elements(array, equal, larger)
            larger -= 1

def swap_elements(array, index1, index2):
    """
    Swap two elements in an array if the indexes are different
    """
    if index1 != index2:
        array[index1], array[index2] = array[index2], array[index1]


array = list(int(value) for value in raw_input('Array (i.e. 123456789): '))
pivot = int(raw_input('Pivot Index: '))
original_array = list(array)
dutch_national_flag(array, pivot)
print 'Results with pivot element %d on array %s: %s' % (original_array[pivot], original_array, array)
