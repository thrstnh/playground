#!/usr/bin/env python
# -*- coding: utf-8 
#


def askok(prompt, retries=3, complaint=' (y/n)? '):
    while True:
        ok = raw_input(prompt + complaint)
        if ok in ('Y', 'y', 'yes',  'Yes' 'J', 'j', 'ja'): return True
        if ok in ('N', 'n', 'No', 'no', 'nein'): return False
        retries = retries - 1
        if retries <= 0: raise IOError, 'refusenik user'

if __name__ == '__main__':
    askok("Wirklich beenden?")