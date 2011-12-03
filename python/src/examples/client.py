#!/usr/bin/env python
# -*- coding: utf8 -*-
import time
import socket

HOST = 'localhost'
PORT = 50007

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST,PORT))

while True:
    s.send('new connection')
    data = s.recv(1024)
    print 'Received', repr(data)
    time.sleep(3)

print 'exit'
s.close()

