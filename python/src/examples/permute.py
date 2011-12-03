#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import os.path

def permute(seq):
    if not seq:
        return [seq]
    else:
        temp = []
        for k in range(len(seq)):
            part = seq[:k] + seq[k+1:]
            for m in permute(part):
                temp.append(seq[k:k+1] + m)
        return temp


if __name__ == '__main__':
    import sys
    l = 'thorsten'
    permute_seq = permute(l)
    with open('permutations.txt', 'w') as fp:
        for item in  permute_seq:
            fp.write(item)
            fp.write(os.linesep)
    #main(sys.argv[1])
