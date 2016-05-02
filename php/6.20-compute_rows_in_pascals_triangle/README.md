#6.20 Compute Rows in Pascal's Triangle
                    1
                1       1
            1       2       1
        1       3       3       1
    1       4       6       4       1

The above figure shows the first five rows of Pascal's triangle.  Each entry in the row before the last one is
adjacent to one or two numbers in the lower row.  It is a fact that each entry holds the sum of the numbers in the
adjacent entries above it.
Write a program which takes as input a non-negative integer n and returns the first n rows of Pascal's triangle.