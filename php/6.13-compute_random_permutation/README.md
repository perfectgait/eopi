#6.13 Compute a Random Permutation
Generating random permutations is not as straightforward as it seems.  For example, iteration through an array A and
swapping each element with another randomly selected element does not generate all permutations of A with equal
probability.
Design an algorithm that creates uniformly random permutations of [0,1,...,n-1].  You are given a random number
generator that returns integers in the set [0,1,...,n-1] with equal probability; use as few calls to it as possible.