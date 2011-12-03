# To change this template, choose Tools | Templates
# and open the template in the editor.

__author__="thrstnh"
__date__ ="$28.07.2009 13:43:35$"

mc = {
    '0' : '-----', '1' : '.----', '2' : '..---',
    '3' : '...--', '4' : '....-', '5' : '.....',
    '6' : '-....', '7' : '--...', '8' : '---..',
    '9' : '----.', 'A' : '.-', 'B' : '-...',
    'C' : '-.-.', 'D' : '-..', 'E' : '.',
    'F' : '..-.', 'G' : '--.', 'H' : '....',
    'I' : '..', 'J' : '.---', 'K' : '-.-',
    'L' : '.-..', 'M' : '--', 'N' : '-.',
    'O' : '---', 'P' : '.--.', 'Q' : '--.-',
    'R' : '.-.', 'S' : '...', 'T' : '-',
    'U' : '..-', 'V' : '...-', 'W' : '.--',
    'X' : '-..-', 'Y' : '-.--', 'Z' : '--..'
}

def encode(s):
    for c in word:
        if c.upper() in mc:
            print mc[c.upper()],
        else:
            print 'not found: ', c,


if __name__ == "__main__":
    word = 'morse morse'
    encode(word)


