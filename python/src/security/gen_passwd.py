#!/usr/bin/env python
from random import Random
import string

def gen_passwd(length=8, chars=string.letters + string.digits):
    return ''.join(Random().sample(chars, length))

if __name__ == "__main__":
    import sys
    print gen_passwd(8)
    print gen_passwd(8)
    print gen_passwd(12)
    print gen_passwd(12)
    print gen_passwd(15, string.letters)
    print gen_passwd(15, string.letters)
    print gen_passwd(15, string.letters)
    print gen_passwd(15, string.letters)
