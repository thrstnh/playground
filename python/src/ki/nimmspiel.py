#!/usr/bin/env python
# -*- coding: utf-8 

class Game(object):

    def __init__(self, count, take_max):
        self._count = count
        self._take_max = take_max
        self.go()


    def max(self, sticks, max, min):
        if sticks <= 1:
            return -1
    
        best = -99
        for i in range(1, self._take_max + 1):
            val = self.min(sticks - i, max, min)
            if val == max:
                return val
            elif val > best:
                best = val
        return best
    
    def min(self, sticks, max, min):
        if sticks <= 1:
            return 1
        
        best = 99
        for i in range(1, self._take_max + 1):
            val = self.max(sticks - i, max, min)
            if val == min:
                return val
            elif val < best:
                best = val
        return best

    def _win(self):
        if self._count == 1:
            return True
        return False
    
    def go(self):
        ki = True
        kimax = ki
        count = 0
        max = 1
        min = -1
        
        while(not self._win()):
            if ki:
                count = 1
                if kimax:
                    for i in range(1, self._take_max + 1):
                        if self.min(self._count - i, max, min) == 1:
                            count = i
                            break
                else:
                    for i in range(1, self._take_max + 1):
                        if self.max(self._count - i, max, min) == -1:
                            count = i
                            break
                print "Sticks auf dem Tisch: %d" % self._count
                ki = not ki
            else:
                print "KI nimmt %d" % count
                prompt = "%d Sticks da, 1-%d ziehen: " % (self._count, self._take_max)
                count = int(raw_input(prompt))
                print "Der Spieler zieht: %d" % count
                ki = not ki
            self._count = self._count - count
        
        if ki:
            print "Player 1 wins!"
        else:
            print "KI nimmt %d, nur noch 1 Stick da" % count
            print "KI wins!"
            

if __name__ == "__main__":
    from sys import argv
    count = int(argv[1])
    take_max = int(argv[2])
    
    Game(count, take_max)               
