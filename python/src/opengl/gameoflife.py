#!/usr/bin/env python
# -*- coding: utf8 -*-

from OpenGL.GL import *
from OpenGL.GLUT import *
from OpenGL.GLU import *
from pygame.locals import *

import pygame
import random

livingSpaceWidth = 12
livingSpaceHeight = 12
livingSpaceDepth = 12

creatureSize = 20

livingSpace = []

xRotation = 0
yRotation = 0

def initLivingSpace():
    for x in range(livingSpaceWidth):
        livingSpace.append([])
        for y in range(livingSpaceHeight):
            livingSpace[x].append([])
            for z in range(livingSpaceDepth):
                if random.randint(0,100) < 19:
                    livingSpace[x][y].append(1000)
                else:
                    livingSpace[x][y].append(0)

def resize((width, height)):
    if height == 0:
        height = 1
    glViewport(0, 0, width, height)
    glMatrixMode(GL_PROJECTION)
    glLoadIdentity()
    glOrtho(-200.0,
            livingSpaceWidth * 20.0 + 200.0,
            livingSpaceHeight * 20.0 + 200.0,
            -200.0,
            -500.0,
            livingSpaceDepth * 20.0 + 500.0)
            
    glMatrixMode(GL_MODELVIEW)
    glLoadIdentity()

def init():
    glClearColor(1.0, 1.0, 1.0, 0.0)
    glClearDepth(1.0)

    # Tiefenpruefung aktivieren
    glEnable(GL_DEPTH_TEST)
    # Art der Pruefung festlegen
    glDepthFunc(GL_LEQUAL)

    # Transparenz aktivieren
    glEnable(GL_BLEND)
    # Art der Transparenzberechnung festlegen
    glBlendFunc(GL_SRC_ALPHA, GL_ONE_MINUS_SRC_ALPHA)
    
    # Beleuchtung aktivieren
    glEnable(GL_LIGHTING)
    # eine Lichtquelle erstellen
    glLightfv(GL_LIGHT0, GL_AMBIENT, [0.6, 0.6, 0.6, 1.0])
    glLightfv(GL_LIGHT0, GL_DIFFUSE, [0.4, 0.4, 0.4, 1.0])
    glLightfv(GL_LIGHT0, GL_POSITION, [
                (livingSpaceWidth * 20.0) / 2.0,
                (livingSpaceHeight * 20.0) / 2.0, -500.0, 1.0])
    # aktivieren der Lichtquelle
    glEnable(GL_LIGHT0)

    # Aktivierung von Materialeigenschaften
    glEnable(GL_COLOR_MATERIAL)
    # diffuses, ambientes Licht für vorder- und rueckseite
    glColorMaterial(GL_FRONT_AND_BACK, GL_AMBIENT_AND_DIFFUSE)

    # automatische Korrektur der Normalen aktivieren
    glEnable(GL_NORMALIZE)
    # bestmoeglich rendern
    glHint(GL_PERSPECTIVE_CORRECTION_HINT, GL_NICEST)


def isAlive(x, y, z):
    return livingSpace[x][y][z] == 1000

def draw():
    glTranslatef(0.0, 0.0, +(livingSpaceDepth * 20.0)/2.0)
    glRotatef(1.0, 0.0, 1.0, 0.0)
    glRotatef(1.0, 1.0, 0.0, 0.0)
    glTranslatef(0.0, 0.0, -(livingSpaceDepth * 20.0)/2.0)
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT)
#    glLoadIdentity()
#    glTranslatef(0.0, 0.0, 3.0)
#    glColor4f(1.0, 0.0, 0.0, 1.0)
    glBegin(GL_QUADS)
    for column in range(livingSpaceWidth):
        for row in range(livingSpaceHeight):
            for depth in range(livingSpaceDepth):
                if livingSpace[column][row][depth] > 0:
                    healthStatus = float(livingSpace[column][row][depth]) / 1000.0
                    if depth % 2 == 0:
                        glColor4f(1.0, 0.0, 0.0, healthStatus)
                    elif depth % 3 == 0:
                        glColor4f(0.0, 1.0, 0.0, healthStatus)
                    else:
                        glColor4f(0.0, 0.0, 1.0, healthStatus)

                    x = column * 20.0
                    y = row * 20.0
                    z = depth * 20.0
                    drawCube(x, y, z, 15.0)
    glEnd()

def drawCube(x, y, z, cubeSize):
    # vordere Seitenflaeche
    glNormal3f(0.0, 0.0, -1.0)
    glVertex3f(x, y, z)
    glVertex3f(cubeSize + x, y, z)
    glVertex3f(cubeSize + x, cubeSize + y, z)
    glVertex3f(x, cubeSize + y, z)

    # hintere Seitenflaeche
    glNormal3f(0.0, 0.0, +1.0)
    glVertex3f(x, y, z + cubeSize)
    glVertex3f(cubeSize + x, y, cubeSize + z)
    glVertex3f(cubeSize + x, cubeSize + y, cubeSize + z)
    glVertex3f(x, cubeSize + y, cubeSize + z)

    # linke Seitenflaeche
    glNormal3f(-1.0, 0.0, 0.0)
    glVertex3f(x, y, z)
    glVertex3f(x, cubeSize + y, z)
    glVertex3f(x, cubeSize + y, cubeSize + z)
    glVertex3f(x, y, cubeSize + z)

    # rechte Seitenflaeche
    glNormal3f(+1.0, 0.0, 0.0)
    glVertex3f(cubeSize + x, y, z)
    glVertex3f(cubeSize + x, cubeSize + y, z)
    glVertex3f(cubeSize + x, cubeSize + y, cubeSize + z)
    glVertex3f(cubeSize + x, y, cubeSize + z)

    # obere Seitenflaeche
    glNormal3f(0.0, +1.0, 0.0)
    glVertex3f(x, cubeSize + y, z)
    glVertex3f(cubeSize + x, cubeSize + y, z)
    glVertex3f(cubeSize + x, cubeSize + y, cubeSize + z)
    glVertex3f(x, cubeSize + y, cubeSize + z)

    # untere Seitenflaeche
    glNormal3f(0.0, -1.0, 0.0)
    glVertex3f(x, y, z)
    glVertex3f(cubeSize + x, y, z)
    glVertex3f(cubeSize + x, y, cubeSize + z)
    glVertex3f(x, y, cubeSize + z)


def getNeighborCount(x, y, z):
    count = 0

    xpn = (x + 1) % livingSpaceWidth
    ypn = (y + 1) % livingSpaceHeight
    zpn = (z + 1) % livingSpaceDepth

    count += isAlive(x, ypn, z-1)
    count += isAlive(xpn, ypn, z-1)
    count += isAlive(xpn, y, z-1)
    count += isAlive(xpn, y-1, z-1)
    count += isAlive(x, y-1, z-1)
    count += isAlive(x-1, y-1, z-1)
    count += isAlive(x-1, y, z-1)
    count += isAlive(x-1, ypn, z-1)

    count += isAlive(x, ypn, z)
    count += isAlive(xpn, ypn, z)
    count += isAlive(xpn, y, z)
    count += isAlive(xpn, y-1, z)
    count += isAlive(x, y-1, z)
    count += isAlive(x-1, y-1, z)
    count += isAlive(x-1, y, z)
    count += isAlive(x-1, ypn, z)

    count += isAlive(x, ypn, zpn)
    count += isAlive(xpn, ypn, zpn)
    count += isAlive(xpn, y, zpn)
    count += isAlive(xpn, y-1, zpn)
    count += isAlive(x, y-1, zpn)
    count += isAlive(x-1, y-1, zpn)
    count += isAlive(x-1, y, zpn)
    count += isAlive(x-1, ypn, zpn)

    count += isAlive(x, y, zpn)
    count += isAlive(x, y, z-1)

    return count

def calculateNextGeneration():
    neighborCount = []
    for column in range(livingSpaceWidth):
        neighborCount.append([])
        for row in range(livingSpaceHeight):
            neighborCount[column].append([])
            for depth in range(livingSpaceDepth):
                neighborCount[column][row].append(getNeighborCount(column, row, depth))

    for column in range(livingSpaceWidth):
        for row in range(livingSpaceHeight):
            for depth in range(livingSpaceDepth):
                if 6 <= neighborCount[column][row][depth] <= 11:
                    if neighborCount[column][row][depth] == 8:
                        # geburts eines lebewesens
                        livingSpace[column][row][depth] = 1000
                else:
                    # langsames sterben
                    livingSpace[column][row][depth] = 0
                    #livingSpace[column][row][depth] = livingSpace[column][row][depth] / 1.5

#                if livingSpace[column][row][depth] < 700:
#                    livingSpace[column][row][depth] = 0

def main():
    video_flags = OPENGL | HWSURFACE | DOUBLEBUF
    screenSize = (livingSpaceWidth * creatureSize,
                    livingSpaceHeight * creatureSize)

    pygame.init()
    pygame.display.gl_set_attribute(GL_MULTISAMPLEBUFFERS, 1)
    pygame.display.gl_set_attribute(GL_MULTISAMPLESAMPLES, 4)
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

        global xRotation, yRotation
        if event.type == KEYDOWN:
            if event.key == K_DOWN:
                xRotation -= 1
            if event.key == K_UP:
                xRotation += 1
            if event.key == K_LEFT:
                yRotation -= 1
            if event.key == K_RIGHT:
                yRotation += 1

        xRotation %= 360
        yRotation %= 360

        draw()
        calculateNextGeneration()
        pygame.display.flip()

if __name__ == '__main__':
    main()
