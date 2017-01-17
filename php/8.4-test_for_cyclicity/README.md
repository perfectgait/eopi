#8.4 Test For Cyclicity
Although a linked list is supposed to be a sequence of nodes ending in a null, it is possible to create a cycle in a
linked list by making the next field of an element reference to one of the earlier nodes.
Given a reference to the head of a singly linked list, how would you determine whether the list ends in a null or
reaches a cycle of node?  Write a program that returns null if there does not exist a cycle, and the reference to the
start of the cycle if a cycle is present.