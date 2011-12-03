#!/usr/bin/env python
# -*- coding: utf8 -*-

import socket
import threading

HOST = ''
PORT = 50007

class worker(threading.Thread):
    def __init__(self, id):
        self.id = id
        threading.Thread.__init__(self)

    def run(self):
        print "worker thread %s" % self.id


s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.bind((HOST,PORT))
s.listen(1)

conn, addr = s.accept()
print 'Connected by', addr

while True:    
    data = conn.recv(1024)
    worker(data).start()
    conn.send('status OK')
    if not data:
        break
    print 'next...'
conn.close()

