# 5.2 Swap Bits
There are a number of ways in which bit manipulations can be accelerated.  For example, the expression x & (x - 1)
equals x with the lowest set bit cleared, and x & ~(x - 1) extracts the lowest set bit of x (all other bits are
cleared).

A 64-bit integer can be viewed as an array of 64 bits, with the bit at index 0 corresponding to the least significant
bit (LSB), and the bit at index 63 corresponding to the most significant bit (MSB).  Implement code that takes as input
a 64-bit integer and swaps the bits in that integer at indices i and j.