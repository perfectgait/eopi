#6.6 Delete Duplicates From an Array
This problem is concerned with deleting repeated elements from a sorted array.  For example, if A =
[2, 3, 5, 5, 7, 11, 11, 11, 13], then after deletion, A = [2, 3, 5, 7, 11, 13].  After deletion there are 6 valid
entries in A.  There are no requirements as to the values stored beyond the last valid element.

Write a program which takes as input a sorted array A and updates A so that all duplicates have been removed and the
remaining elements have been shifted left to fill the emptied indices.  Return the number of valid elements in A.  Many
languages have library functions for performing this operation.  You cannot use these functions.  (Imagine you are
implementing the corresponding library).