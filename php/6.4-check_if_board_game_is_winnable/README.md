#6.4 Check if a Board Game is Winnable
In a particular board game, players have to try to advance through a sequence of positions.  Each position has a
non-negative integer associated with it, representing the maximum you can advance from that position in one move.  For
example, let A = [3, 3, 1, 0, 2, 0, 1] represent the board game, i.e., the i-th entry in A is the maximum we can advance
from i.  Then the following sequence of advances leads to the last position: [1, 3, 2].  If A = [3, 2, 0, 0, 2, 0, 1],
it is not possible to advance past position 3.
Write a program which takes an array on n integers, where A[i] denotes the maximum you can advance from index i, and
returns whether it is possible to advance to the last index starting from the beginning of the array.