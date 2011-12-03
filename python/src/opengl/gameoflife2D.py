#!/usr/bin/env python
# -*- coding: utf8 -*-

from OpenGL.GL import *
from OpenGL.GLUT import *
from OpenGL.GLU import *
from pygame.locals import *

import pygame
import random

livingSpaceWidth = 100
livingSpaceHeight = 60

creatureSize = 10

livingSpace = []

def initLivingSpace():
    for x in range(livingSpaceWidth):
        livingSpace.append([])
        for y in range(livingSpaceHeight):
            if random.randint(0,1) == 1:
                livingSpace[x].append(1000)
            else:
                livingSpace[x].append(0)

def resize((width, height)):
    if height == 0:
        height = 1
    glViewport(0, 0, width, height)
    glMatrixMode(GL_PROJECTION)
    glLoadIdentity()
    glOrtho(-10.0, livingSpaceWidth * 10.0 + 10.0, livingSpaceHeight * 10.0 + 10.0, -10.0, -6.0, 0.0)
    glMatrixMode(GL_MODELVIEW)
    glLoadIdentity()

def init():
    glClearColor(0.0, 0.0, 0.0, 0.0)

def isAlive(x, y):
    return livingSpace[x][y] == 1000

def draw():
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT)
    glLoadIdentity()
    glTranslatef(0.0, 0.0, 3.0)
    glColor4f(1.0, 0.0, 0.0, 1.0)
    glBegin(GL_QUADS)
    for column in range(livingSpaceWidth):
        for row in range(livingSpaceHeight):
            healthStatus = float(livingSpace[column][row]) / 1000.0
            glColor4f(healthStatus, 0.0, 0.0, 1.0)
            x = column * 10.0
            y = row * 10.0
            glVertex3f(x, y, 0.0)
            glVertex3f(9.0 + x, y, 0.0)
            glVertex3f(9.0 + x, 9.0 + y, 0.0)
            glVertex3f(x, 9.0 + y, 0.0)
    glEnd()

def getNeighborCount(x, y):
    count = 0

    xpn = (x + 1) % livingSpaceWidth
    ypn = (y + 1) % livingSpaceHeight

    count += isAlive(x, ypn)
    count += isAlive(xpn, ypn)
    count += isAlive(xpn, y)
    count += isAlive(xpn, y - 1)
    count += isAlive(x, y - 1)
    count += isAlive(x - 1, y - 1)
    count += isAlive(x - 1, y)
    count += isAlive(x - 1, ypn)
    return count

def calculateNextGeneration():
    neighborCount = []
    for column in range(livingSpaceWidth):
        neighborCount.append([])
        for row in range(livingSpaceHeight):
            neighborCount[column].append(getNeighborCount(column, row))

    for column in range(livingSpaceWidth):
        for row in range(livingSpaceHeight):
            if 2 <= neighborCount[column][row] <= 3:
                if neighborCount[column][row] == 3:
                    # geburts eines lebewesens
                    livingSpace[column][row] = 1000
            else:
                # langsames sterben
                livingSpace[column][row] = livingSpace[column][row] / 1.1
                
            if livingSpace[column][row] < 200:
                livingSpace[column][row] = 0

def main():
    video_flags = OPENGL | HWSURFACE | DOUBLEBUF
    screenSize = (livingSpaceWidth * creatureSize,
                    livingSpaceHeight * creatureSize)

    pygame.init()
    pygame.display.set_mode(screenSize, video_flags)

    initLivingSpace()
    resize(screenSize)
    init()

    frame = 0
    ticks = pygame.time.get_ticks()
    while True:
        event = pygame.event.poll()
        if event.type == QUIT or (event.type == KEYDOWN and event.key == K_ESCAPE):
            break
        draw()
        calculateNextGeneration()
        pygame.display.flip()

if __name__ == '__main__':
    main()
