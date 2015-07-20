# 7.2 Replace and Remove
Consider the following two rules that are to be applied to strings over the alphabets ["a", "b", "c", "d"].

* Replace each "a" by "dd"
* Delete each "b"

It is straightforward to implement a function that takes a string s as an argument, and applies these rules to s if the
function can allocate O(n) additional storage, where n is the length of s.

Write a program which takes as input a string s, and removes each "b" and replaces each "a" by "dd."  Assume s is
stored in an array that has enough space for the final result.