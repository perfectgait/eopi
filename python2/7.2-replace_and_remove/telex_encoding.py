"""
Telex encode an array of characters by replacing punctuations with their spelled out value.
"""

__author__ = "Matt Rathbun"
__email__ = "mrathbun80@gmail.com"
__version__ = "1.0"


def telex_encode(array):
    """
    Telex encode an array of characters using the map of special characters
    """
    special_string_length = 0
    char_map = {
        '.': 'DOT',
        ',': 'COMMA',
        '?': 'QUESTION MARK',
        '!': 'EXCLAMATION MARK'
    }

    for char in array:
        if char in char_map:
            # Make sure to subtract one for the special character that is being replaced
            special_string_length += len(char_map[char]) - 1

    if special_string_length > 0:
        current_index = len(array) - 1
        array += [''] * special_string_length
        write_index = len(array) - 1

        while current_index >= 0:
            if array[current_index] in char_map:
                for i in range(len(char_map[array[current_index]]) - 1, -1, -1):
                    array[write_index] = char_map[array[current_index]][i]
                    write_index -= 1
            else:
                array[write_index] = array[current_index]
                write_index -= 1

            current_index -= 1

    return array


string = raw_input('String: ')
original_string = string
print 'The telex encoding of the string %s is %s' % (original_string, ''.join(telex_encode(list(string))))