#!/usr/bin/env python
# -*- coding: utf-8 

class queue(object):
    def __init__(self):
        self.queue = []
        
    def push(self, elem):
        self.queue.append(elem)
    
    def pop(self):
        return self.queue.pop(0)
    
    def __str__(self):
        return str([elem for elem in self.queue])


if __name__ == "__main__":
    
    s = queue()
    #print s
    s.push(1)
    s.push(2)
    s.push(3)
    s.push(4)
    print s
    s.pop()
    print s
    s.push(5)
    s.push(6)
    print s
    s.pop()
    print s
    s.push(7)
    print s  