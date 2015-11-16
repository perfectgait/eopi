#6.1 Dutch National Flag
The quicksort algorithm for sorting arrays proceeds recursively.  It select an element x (the "pivot"), reorders the
array to make all the elements less than or equal to x appear fist, followed by all the elements greater than x.  The 
two sub-arrays are then sorted recursively.

Implemented natively, quicksort has large run times on arrays with many duplicates because the sub-arrays may differ
greatly in size.  One solution is to reorder the array so that all elements less than x appear first, followed by
elements equal to x, followed by elements greater than x.  This is known as Dutch national flag partitioning because the
Dutch national flag consists of three horizontal bands, each in a different color.

When ar array consists of entries from a small set of keys, e.g., {0, 1, 2}, one way to sort it is to count the number
of occurrences of each key.  Consequently, enumerate the keys in sorted order and write the corresponding number of keys
to the array.  If a BST is used for counting, the time complexity of this approach is O(n log k), where n is the array
length and k is the number of keys.  This is known as counting sort.

Counting sort, as just described, does not differentiate among different objects with the same key value.  The current
problem is concerned with a special case of counting sort when entries are objects rather than keys.

Write a program that takes an array A of length n and an index i into A, and rearranges the elements such that all
elements less than A[i] appear first, followed by elements equal to A[i], followed by elements greater than A[i].