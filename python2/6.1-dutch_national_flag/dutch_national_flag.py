"""
Solve the dutch national flag problem where an array is partitioned into elements less than the pivot, equal to the
pivot and greater than the pivot

The time complexity is O(n) for dutch_national_flag
The time complexity is O(n) for dutch_national_flag_three_possible_keys
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


def dutch_national_flag_three_possible_keys(array, pivot):
    """
    Handle the dutch national flag problem by grouping all objects with the same key together.  Each object can have
    one of three keys.  This uses O(1) extra storage to record the key corresponding to the first group of items.
    """
    first = 0
    second = 0
    third = len(array) - 1
    pivot_element = array[pivot]['key']
    first_key = None

    while second <= third:
        if array[second]['key'] != pivot_element and (first_key is None or first_key == array[second]['key']):
            if first_key is None:
                first_key = array[second]['key']

            swap_elements(array, second, first)
            first += 1
            second += 1

        elif array[second]['key'] != pivot_element:
            second += 1

        else:
            swap_elements(array, second, third)
            third -= 1

def dutch_national_flag_four_possible_keys(array, pivot):
    """
    Handle the dutch national flag problem by grouping all objects with the same key together.  Each object can have
    one of four keys.  This uses O(1) extra storage
    """
    pivot_element = array[pivot]['key']
    first = 0
    second = 0
    third = 0
    fourth = len(array) - 1
    keys = [None, None, None, pivot_element]

    # while second <= third:
    #     if array[second]['key'] != pivot_element and (keys[0] is None or array[second]['key'] == keys[0]):
    #         if keys[0] is None:
    #             keys[0] = array[second]['key']
    #
    #         swap_elements(array, second, first)
    #         first += 1
    #         second += 1
    #
    #     elif array[second]['key'] != pivot_element and (keys[1] is None or array[second]['key'] == keys[1]):
    #         if keys[1] is None:
    #             keys[1] = array[second]['key']
    #
    #         second += 1
    #
    #     elif array[second]['key'] != pivot_element and (keys[2] is None or array[second]['key'] == keys[2]):
    #         if keys[2] is None:
    #             keys[2] = array[second]['key']
    #
    #         swap_elements(array, second, third)
    #         third -= 1
    #
    #     else:
    #         swap_elements(array, second, fourth)
    #         fourth -= 1
    #         third -= 1



    while third <= fourth:
        if array[third]['key'] != pivot_element and (keys[0] is None or array[third]['key'] == keys[0]):
            if keys[0] is None:
                keys[0] = array[third]['key']

            print 'swap %d and %d' % (third, first)
            print array
            print '\n'
            swap_elements(array, third, first)
            first += 1
            second += 1
            third += 1
            # print array

        elif array[third]['key'] != pivot_element and (keys[1] is None or array[third]['key'] == keys[1]):
            if keys[1] is None:
                keys[1] = array[third]['key']

            # print 'key: ' + str(array[third]['key'])
            # print 'first: ' + str(first)
            # print 'pre second: ' + str(second)
            # print 'pre third: ' + str(third)
            # print 'fourth: ' + str(fourth)
            # print array

            print 'swap %d and %d' % (third, second)
            print array
            swap_elements(array, third, second)


            second += 1
            third += 1

            # print 'post second: ' + str(second)
            # print 'post third: ' + str(third)
            # print array
            print '\n'

        elif array[third]['key'] != pivot_element:
            # print 'key: ' + str(array[third]['key'])
            # print 'first: ' + str(first)
            # print 'second: ' + str(second)
            # print 'pre third: ' + str(third)
            # print 'fourth: ' + str(fourth)
            print 'no swap'
            print array
            third += 1

            # print 'post third: ' + str(third)
            # print array
            print '\n'

        else:
            print 'swap %d and %d' % (third, fourth)
            print array
            print '\n'
            swap_elements(array, third, fourth)
            fourth -= 1

    #
    print keys

def swap_elements(array, index1, index2):
    """
    Swap two elements in an array if the indexes are different
    """
    if index1 != index2:
        array[index1], array[index2] = array[index2], array[index1]


# array = list(int(value) for value in raw_input('Array (i.e. 123456789): '))
# pivot = int(raw_input('Pivot Index: '))
# original_array = list(array)
# dutch_national_flag(array, pivot)
# print 'Results with pivot element %d on array %s: %s' % (original_array[pivot], original_array, array)
#
# array2 = [
#     {
#         'key': 1
#     },
#     {
#         'key': 2
#     },
#     {
#         'key': 3
#     },
#     {
#         'key': 1
#     },
#     {
#         'key': 2
#     },
#     {
#         'key': 3
#     },
# ]
# pivot2 = 0
# original_array2 = list(array2)
# dutch_national_flag_three_possible_keys(array2, pivot2)
# print 'Results with pivot element %d on array %s: %s' % (original_array2[pivot2]['key'], original_array2, array2)

array3 = [
    {
        'key': 1
    },
    {
        'key': 2
    },
    {
        'key': 3
    },
    {
        'key': 4
    },
    {
        'key': 1
    },
    {
        'key': 2
    },
    {
        'key': 3
    },
    {
        'key': 4
    }
]
pivot3 = 1
original_array3 = list(array3)
dutch_national_flag_four_possible_keys(array3, pivot3)
print 'Results with pivot element %d on array\n%s:\n%s' % (original_array3[pivot3]['key'], original_array3, array3)
