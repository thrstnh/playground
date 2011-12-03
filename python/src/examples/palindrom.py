#!/usr/bin/env python

def palindrom(palin):
    palin_letters = [c for c in palin.lower() if c.isalpha()]
    print palin_letters
    return (palin_letters == palin_letters[::-1])

if __name__ == "__main__":
    import sys
    if(palindrom(sys.argv[1])):
        print "Ist ein Palindrom!"
    else:
        print "Ist KEIN Palindrom!"
