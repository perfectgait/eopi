"""
Compute the parity of a large (64-bit) number using different methods.  The parity of a binary word is 1 if the number
of 1's in the word is odd and 0 if not.
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def compute_parity_brute_force(number):
    """
    Compute the parity of a number using brute force.  The way this works is by comparing the LSB each bit pass to see
    if it's toggled using a bitwise and operator.  The result is then compared using the xor bitwise operator.  Then the
    LSB is shifted off to the right.
    i.e.
    64 = 1000000
    1000000 / result = 0
    0100000 / result = 0
    0010000 / result = 0
    0001000 / result = 0
    0000100 / result = 0
    0000010 / result = 0
    0000001 / result = 1
    parity of 64 is 1

    65 = 1000001
    1000001 / result = 1
    0100000 / result = 1
    0010000 / result = 1
    0001000 / result = 1
    0000100 / result = 1
    0000010 / result = 1
    0000001 / result = 0
    parity of 65 is 0
    """
    result = 0
    iterations = 0

    while number:
        result ^= (number & 1)

        number >>= 1
        iterations += 1

    return result, iterations

def compute_parity_erase_lowest_set_bit(number):
    """
    Compute the parity of a number using a technique to erase the LSB.
    i.e.
    64 = 1000000
    1000000 / result = 1
    parity of 64 is 1
    This works because 64 is &'d with 63 = 1000000 is &'d with 0111111.  As we can see that operation will return 0
    which evaluates to false so the while loop terminates.

    65 = 1000001
    1000001 / result = 1
    1000000 / result = 0
    parity of 65 is 0

    This improves performance in the best and average cases but can still be as slow as brute force.  For example if run
    on 9223372036854775807 it will take 63 iterations which matches brute force.
    """
    result = 0
    iterations = 0

    while number:
        result ^= 1

        number &= (number - 1)
        iterations += 1

    return result, iterations

def compute_parity_cache(number):
    """
    Compute the parity of a number by breaking it into 4 16 bit words and comparing the parity of each word.  The first
    step is to cache the parity of all 16 bit words and then we can use the cached values to speed up the check of the
    number we want to test.  There are no iterations done on the number itself however computing the cache will take
    some time.  In the real world this caching would be done once and stored statically somewhere.
    i.e.
    64 = 1000000 which is
    parity[0000000000000000] ^ parity[0000000000000000] ^ parity[0000000000000000] ^ parity[0000000001000000] or
    0 ^ 0 ^ 0 ^ 1 = 1

    The reason for the shifting and &'d when looking up the precomputed parity is because we always want to look up a
    16-bit index.  If we did not do this the last lookup in the precomputer parity list could actually search for a
    number larger than we have precomputed the parity for.
    """
    word_size = 16
    precomputed_parity = []
    bitmask = 0b1111111111111111

    for i in range (0, bitmask):
        parity = compute_parity_erase_lowest_set_bit(i)
        precomputed_parity.append(parity[0])

    return precomputed_parity[number >> (3 * word_size)] ^\
           precomputed_parity[(number >> (2 * word_size)) & bitmask] ^\
           precomputed_parity[(number >> word_size) & bitmask] ^\
           precomputed_parity[number & bitmask]

def compute_parity_shifting(number):
    """
    Compute the parity of a number by comparing the number to smaller halves of itself over and over.  Because XOR is
    commutative we can XOR a 64-bit number 6 times to compute its parity.
    i.e. 64 = 0000000000000000000000000000000000000000000000000000000001000000
        0000000000000000000000000000000000000000000000000000000001000000
    ^                                   00000000000000000000000000000000 / Shift 32 bits
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001000000
    ^                   000000000000000000000000000000000000000000000000 / Shift 16 bits
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001000000
    ^           00000000000000000000000000000000000000000000000000000000 / Shift 8 bits
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001000000
    ^       000000000000000000000000000000000000000000000000000000000100 / Shift 4 bits
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001000100
          00000000000000000000000000000000000000000000000000000000010001 / Shift 2 bits
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001010101
    ^    000000000000000000000000000000000000000000000000000000000101010 / Shift 1 bit
    --------------------------------------------------------------------
        0000000000000000000000000000000000000000000000000000000001111111
    &                                                                  1
    --------------------------------------------------------------------
                                                                       1
    """
    bitmask = 0b1111111111111111111111111111111111111111111111111111111111111111
    number &= bitmask

    number ^= number >> 32
    number ^= number >> 16
    number ^= number >> 8
    number ^= number >> 4
    number ^= number >> 2
    number ^= number >> 1

    return number & 1

number = int(raw_input())
brute_force_results = compute_parity_brute_force(number)
print 'parity of %d using compute_parity_brute_force is: %d, the number of iterations required is: %d' \
      % (number, brute_force_results[0], brute_force_results[1])

erase_lowest_bit_results = compute_parity_erase_lowest_set_bit(number)
print 'parity of %d using compute_parity_erase_lowest_set_bit is: %d, the number of iterations required is: %d' \
      % (number, erase_lowest_bit_results[0], erase_lowest_bit_results[1])

cache_results = compute_parity_cache(number)
print 'parity of %d using compute_parity_cache is: %d' % (number, cache_results)

shifting_results = compute_parity_shifting(number)
print 'parity of %d using compute_parity_shifting is: %d' % (number, shifting_results)
