"""
Convert from a string to an integer and vice versa
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def int_to_string(integer):
    """
    Convert an integer to a string.  This works by taking the modulo of the integer and dividing it by 10 until it is
    <= 0.

    i.e. 987

    Iteration 1
    987 % 10 = 7
    987 / 10 = 98
    string = 7

    Iteration 2
    98 % 10 = 8
    98 / 10 = 9
    string = 78

    Iteration 3
    9 % 10 = 9
    9 / 10 = 0
    string = 789

    reversing the string we get 987
    """
    is_negative = integer < 0
    string = ''

    # Handle the edge case of 0
    if integer == 0:
        return '0'

    if is_negative:
        integer *= -1

    while integer:
        # @TODO Handle edge case where string length exceeds maximum
        string += str(integer % 10)
        integer /= 10

    if is_negative:
        string += '-'

    # Reverse the string
    return string[::-1]

def string_to_int(string):
    """
    Convert a string to an integer.  This works by the same principle as converting a number to a certain base.  Each
    digit in the string length n is multiplied by the base^n-k and added to the result.  The normal process of base
    conversion works from right to left but there is an elegant solution to handle it left to right which is what is
    used here.  By adding from left to right and multiplying by the base (10) each time the effect of multiplying each
    digit by the base^n-k is reproduced.  For example if the left-most digit is 9 and the string is length 3 then 9 will
    be added to the integer and multiplied by 10 twice or 10^2.

    i.e. 563

    Iteration 1
    integer = 0 * 10 + 5 = 5

    Iteration 2
    integer = 5 * 10 + 6 = 56

    Iteration 3
    integer = 56 * 10 + 3 = 563
    """
    is_negative = string[0] == '-'
    integer = 0
    start = 0

    if is_negative:
        start = 1

    for i in range(start, len(string)):
        digit = int(string[i])
        # @TODO Handle edge case where number exceeds maximum int
        integer = integer * 10 + digit

    if is_negative:
        integer *= -1

    return integer


integer = int(raw_input('Integer: '))
print 'The integer %d is converted to string %s' % (integer, int_to_string(integer))

string = str(raw_input('String: '))
print 'The string %s is converted to integer %d' % (string, string_to_int(string))
