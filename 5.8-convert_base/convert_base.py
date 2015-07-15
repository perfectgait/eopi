"""
Convert a number from one base to another where both bases are between 2 and 16 (inclusive).
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def convert_base(number, base1, base2):
    """
    Convert number from base1 to base2
    i.e. 245 in base 6 to base 14 is:


    """
    is_negative = number[0] == '-'
    x = 0
    start = 0
    character_values = {
        'A': 10,
        'B': 11,
        'C': 12,
        'D': 13,
        'E': 14,
        'F': 15
    }

    if is_negative:
        start = 1

    # Convert the number
    for i in range(start, len(number)):
        # x *= base1

        try:
            x += int(number[i]) * pow(base1, i)
            print x
        except TypeError:
            x += character_values[number[i]] * pow(base1, i)

    return str(x)


number = str(raw_input('Number: '))
base1 = int(raw_input('Base 1: '))
base2 = int(raw_input('Base 2: '))
print 'The number %s in base %d is %s in base %d' % (number, base1, convert_base(number, base1, base2), base2)
