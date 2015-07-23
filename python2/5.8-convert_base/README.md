# 5.8 Convert Base
In the decimal system, the position of a digit is used to signify the power of 10 that digit is to be multiplied with.
For example, "314" denotes the number 3 x 100 + 1 x 10 + 4 x 1.  The base b number system generalizes the decimal number
system: the string "a(sub k-1) x a(sub k-2 ... a(sub 1) x a(sub 0)," where 0 <= a(sub i) < b, denotes in base-b the
integer a(sub 0) x b^0 + a(sub 1) x b^1 + a(sub 2) x b^2 + ... + a(sub k-1) x b^k-1.

Write a program that performs base conversion,  Specifically, the input is an integer base b(sub 1), a string s,
representing an integer x in base b(sub 1), and another integer base b(sub 2); the ouput is the string representing the
integer x in base b(sub 2).  Assume 2 <= b(sub 1), b(sub 2) <= 16.  Use "A" to represent 10, "B" for 11, ..., and "F"
for 15.