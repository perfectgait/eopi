"""
Convert a number from one base to another where both bases are between 2 and 16 (inclusive).

The time complexity is O(n(1 + log(base base2)base1)), where n is the length of s.  The reasoning is as follows.
First, we perform n multiply-and-adds to get x from s.  Then we perform log(base base2)x multiply and adds to get
the result.  The value x is upper-bounded by base1^n, and log(base base 2)base1^n = nlog(base base2)base1
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def convert_base(number, base1, base2):
    """
    Convert number from base1 to base2
    i.e. 245 in base 6 to base 14 is:

    first convert the number to decimal (base 10)
    -------------------------------------------------
    = 2 * 6^2 + 4 * 6^1 + 5 * 6^0
    = 2 * 36 + 4 * 6 + 5 * 1
    = 72 + 24 + 5
    = 101 in base 10

    then convert the decimal to base 14
    -------------------------------------------------
    = 101 / 14 = 7 R 3
    = 73 in base 14

    i.e. 1045 in base 8 to base 9 is:

    first convert the number to decimal (base 10)
    -------------------------------------------------
    = 1 * 8^3 + 0 * 8^2 + 4 * 8^1 + 5 * 8^0
    = 1 * 512 + 0 * 64 + 4 * 8 + 5 * 1
    = 512 + 0 + 32 + 5
    = 549 in base 10

    then convert the decimal to base 9
    -------------------------------------------------
    = 549 / 9 = 61 R 0
    = 61 / 9 = 6 R 7
    = 670 in base 9

    HOW IT WORKS
    -------------------------------------------------
    Converting from the original base to decimal happens left to right by performing the multiplication by the base
    first in each iteration.  Using the first example from above (245 in base 6 to base 14) we have:

    Iteration 1:
    x *= 6 / x = 0
    x += 2 / x = 2

    Iteration 2:
    x *= 6 / x = 12
    x += 4 / x = 16

    Iteration 3:
    x *= 6 / x = 96
    x += 5 / x = 101

    Doing this the 2 gets multiplied by the base twice or 2 * 6^2, 4 gets multiplied by the base once or 4 * 6^1 and 5
    gets multiplied by the base never or 5 * 6^0.  Yielding 2 * 6^2 + 4 * 6^1 + 5 * 6^0 which is the same as the
    elementary formula.

    -------

    Coverting from the decimal to the new base happens by repeatedly computing the remainder at each position.  Using
    the first example from above (245 in base 6 to base 14.  Decimal value 101) we have:

    Iteration 1:
    remainder = 101 % 14 / remainder = 3 or (98 R 3)
    result = 3
    x = 101 / 14 / x = 7

    Iteration 2:
    remainder = 7 % 14 / remainder = 7 or (0 R 7)
    result = 37
    x = 7 / 14 / x = 0

    The result is then reversed for a value of 73
    """
    is_negative = number[0] == '-'
    x = 0
    start = 0
    character_translations = {
        'A': 10,
        'B': 11,
        'C': 12,
        'D': 13,
        'E': 14,
        'F': 15
    }
    value_translations = {
        10: 'A',
        11: 'B',
        12: 'C',
        13: 'D',
        14: 'E',
        15: 'F'
    }

    if is_negative:
        start = 1

    # Convert the number to a decimal
    for i in range(start, len(number)):
        x *= base1

        try:
            x += int(number[i])
        except ValueError:
            x += character_translations[number[i].upper()]

    result = []

    # Convert the decimal to the new base
    while x:
        remainder = x % base2

        if remainder >= 10:
            remainder = value_translations[remainder]

        result.append(remainder)
        x /= base2

    if is_negative:
        result.append('-')

    result.reverse()

    return ''.join(str(value) for value in result)


number = str(raw_input('Number: '))
base1 = int(raw_input('Base 1: '))
base2 = int(raw_input('Base 2: '))
print 'The number %s in base %d is %s in base %d' % (number, base1, convert_base(number, base1, base2), base2)
