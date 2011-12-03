#!/usr/bin/env python
# -*- coding: utf-8 

class stack(object):
    def __init__(self):
        self.stack = []
        
    def push(self, elem):
        self.stack.append(elem)
    
    def pop(self):
        return self.stack.pop()
    
    def __str__(self):
        return str([elem for elem in self.stack])
    

    
if __name__ == "__main__":
    
    s = stack()
    print s
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