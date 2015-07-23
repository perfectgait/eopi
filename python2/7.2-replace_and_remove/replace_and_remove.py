"""
Replace and remove characters from a string without allocating a new string with the same length as the original one.

The time complexity of replace_and_remove is O(n)
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def replace_and_remove(string):
    """
    Replace all instances of "a" with "dd" and remove all instances of "b" from the string.  The important part is that
    this will not allocate a new string and instead use the existing one.  The way this works is by first replacing all
    b's and counting the number of a's.  After that it re-sizes the string to accommodate the extra characters needed
    for each a.  Then it works from the end of the original string and adds each character to the end of the re-sized
    string.

    i.e. acbdab

    After first pass
    string = "acda"

    After padding
    string = "acda  "

    After second pass
    string = "ddcddd"
    """
    write_index = 0
    a_count = 0
    # Convert the string to a list so we can modify it easily
    string = list(string)

    # First pass through removes all b characters and counts the number of a's
    for char in string:
        if char != 'b':
            string[write_index] = char
        else:
            string[write_index] = ''

        write_index += 1

        if char == 'a':
            a_count += 1

    string += [''] * (write_index + a_count - len(string))

    # Second pass through works from the end of the original string and writes characters starting at the end of the
    # string now.
    current_index = write_index - 1
    write_index = len(string) - 1

    # for i in range(current_index, -1, -1):
    while current_index >= 0:
        if string[current_index] == 'a':
            string[write_index] = 'd'
            write_index -= 1
            string[write_index] = 'd'
            write_index -= 1
        elif string[current_index] != 'b':
            string[write_index] = string[current_index]
            write_index -= 1

        current_index -= 1

    return ''.join(string)


string = str(raw_input('String: '))
print 'The string "%s" after the rules are applied is "%s"' % (string, replace_and_remove(string))