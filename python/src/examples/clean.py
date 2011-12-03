#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os, sys

def class_cleaner(arg, dirname, names):
    for name in names:
        if name.endswith('.class'):
            print 'rm %s/%s' % (dirname, name)
            os.remove(os.path.join(dirname, name))

if __name__ == '__main__':
    dn = sys.argv[1]
    os.path.walk(dn, class_cleaner, None)
