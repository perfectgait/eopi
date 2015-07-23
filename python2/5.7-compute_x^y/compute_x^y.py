"""
Compute the value of x^y

The time complexity is O(n) where n is the number of bits needed to represent y.
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def compute_power_brute_force(x, y):
    """
    Compute the value of x^y using a brute force approach where the number of iterations is dictated by the exponent.
    """
    result = 1
    iterations = 0
    power = abs(y)

    # Handle negative exponents
    if y < 0:
        x = 1 / x

    for i in range(0, power):
        result *= x
        iterations += 1

    return result, iterations

def compute_power_divide_and_conquer(x, y):
    """
    Use a divide and conquer approach to solving the problem of raising a number to a power.
    i.e.
    2^10 = 2^(0b1010) = 2^(0b0101 + 0b0101) = 2^(0b0101) * 2^(0b0101)

    Iteration 1:
    power start = 0b1010
    power & 1 is false
    result = 1
    x = 4
    power end = 0b0101

    Iteration 2:
    power start = 0b0101
    power & 1 is true
    result = 4
    x = 16
    power end = 0b0010

    Iteration 3:
    power start = 0b0010
    power & 1 is false
    result = 4
    x = 256
    power end = 0b0001

    Iteration 4:
    power start = 0b0001
    power & 1 is true
    result = 1024
    x = 65536
    power end = 0b0000

    RESULT IS 1024

    ====================================================================================================================

    2^9 = 2^(0b1001) = 2^(0b1000 + 0b0001) = 2^(0b1000) * 2 = 2^(0b0100 + 0b0100) * 2 = 2^(0b0100) * 2^(0b0100) * 2

    Iteration 1:
    power start = 0b1001
    power & 1 is true
    result = 2
    x = 4
    power end = 0b0100

    Iteration 2:
    power start = 0b0100
    power & 1 is false
    result = 2
    x = 16
    power end = 0b0010

    Iteration 3:
    power start = 0b0010
    power & 1 is false
    result = 2
    x = 256
    power end = 0b0001

    Iteration 4:
    power start = 0b0001
    power & 1 is true
    result = 512
    x = 65536
    power end = 0b0000

    RESULT IS 512
    """
    result = 1
    iterations = 0
    power = abs(y)

    # Handle negative exponents
    if y < 0:
        x = 1 / x

    while power:
        if power & 1:
            result *= x

        x *= x
        power >>= 1
        iterations += 1

    return result, iterations

x = float(raw_input('x: '))
y = int(raw_input('y: '))
brute_force_result = compute_power_brute_force(x, y)
print '%f^%d = %f using compute_power_brute_force, the number of iterations required is %f' \
      % (x, y, brute_force_result[0], brute_force_result[1])

divide_and_conquer_result = compute_power_divide_and_conquer(x, y)
print '%f^%d = %f using compute_power_divide_and_conquer, the number of iterations required is %f' \
      % (x, y, divide_and_conquer_result[0], divide_and_conquer_result[1])
