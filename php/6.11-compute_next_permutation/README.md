#6.11 Compute the Next Permutation
There exist exactly n! permutations of n elements.  These can be totally ordered using the dictionary ordering.  Define
permutation p to appear before permutation q if in the first place where p and q differ in their array representations,
starting from index 0, the corresponding entry for p is less than that for q.  For example, [2, 0, 1] < [2, 1, 0].  Note
that the permutation [0, 1, 2] is the smallest permutation under dictionary ordering and [2, 1, 0] is the largest
permutation under dictionary ordering.
Given a permutation p, return the next permutation under dictionary ordering.  If p is the last permutation, return the
empty array.  For example, if p = [1, 0, 3, 2] your function should return [1, 2, 0, 3].