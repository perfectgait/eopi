#6.3 Multiply Two Big Integers
Certain applications require arbitrary precision arithmetic.  One way to achieve this is to use strings to represent
integers, e.g., with one digit or negative sign per character entry, with the most significant digit appearing first.
Write a progam that take two strings representing integers, and returns an integer representing their product.  For
example, since 193707721 x -761838257287 = -147573952589676412927, if the inputs are "193707721" and +-761838257287,"
your function should return "-147573952589676412927."