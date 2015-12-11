#6.5 - Delete a Key From an Array
This problem is concerned with writing a remove function for arrays.  Often, languages have library functions for
performing this operation.  You cannot use these functions.  (Imagine you are implementing the corresponding library.

Implement a function which takes as input an array A of integers and an integer k, and updates A so that all
occurrences of k have been removed and the remaining elements have been shifted left to fill the empty indices.  Return
the number of remaining elements.  There are no requirements as to the value stored beyond the last valid element.  For
example, if A = [5, 3, 7, 11, 2, 3, 13, 5, 7] and k = 3, then [5, 7, 11, 2, 13, 5, 7, 0, 0] is an acceptable update to
A, and the return value is 7.