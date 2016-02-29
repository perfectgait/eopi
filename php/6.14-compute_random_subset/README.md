#6.14 Compute a Random Subset of [0,1,...,n-1]
The set [0,1,2,...,n-1] has exactly n!/((n-k)!k!) subsets of size k.  We seek to design an algorithm that returns any
one of these subsets with equal probability.
Design an algorithm that computes an array of size k consisting of distinct integers in the set [0,1,...,n-1].  All
subsets should be equally likely and, in addition, all permutations of elements of the array should be equally likely.
Your time complexity should be O(k).  Your algorithm can use O(k) space in addition to the k element array for the
result.  You may assume the existence of a library function which takes as input a non-negative integer t and returns an
integer in the set [0,1,...,n-1] with uniform probability.