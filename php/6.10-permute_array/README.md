#6.10 Permute the Elements of an Array
A permutation is a rearrangement of members of a sequence into a new sequence.  For example there are 24 permutations
of [a, b, c, d]; some of these are [b, a, d, c], [d, a, b, c] and [a, d, b, c].
A permutation can be specified by an array P, where P[i] represents the location of the element at i in the permutation.
For example, the array [2, 0, 1, 3] represent the permutation that maps the element at location 0 to location 2, the
element at location 1 to location 0, the element at location 2 to location 1 and keep the element at location 3
unchanged.  A permutation can be applied to an array to re-order the array.  For example, the permutation [2, 0, 1, 3]
applied to A = [a, b, c, d] yields the array [b, c, a, d].
It is simple to apply a permutation-array to a given array if additional storage is available to write the resulting
array.
Given an array A on n elements and a permutation P, apply P to A using only constant additional storage.  Use A itself
to write the resulting array.