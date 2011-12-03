#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os.path
from multiprocessing.sharedctypes import synchronized
from multiprocessing import Process
import time
import threading
from threading import Lock
from Queue import Queue
import socket
from config import config as cfg

__author__="thrstnh"
__date__ ="$08.12.2010 23:07:51$"

loginit = 'arLog\n'
TIME_PATTERN = '%Y-%m-%d--%H:%M:%S'

def now():
    return time.strftime(TIME_PATTERN)

logfile_lock = Lock()
def synchronized(lock):
    """ Synchronization decorator. """
    def wrap(f):
        def new_function(*args, **kw):
            lock.acquire()
            try:
                return f(*args, **kw)
            finally:
                lock.release()
        return new_function
    return wrap

class ArTCPLogServer(object):
    ''' use this one as server '''
    def __init__(self, hostname, port):
        #threading.Thread.__init__(self)
        self._hostname = hostname
        self._port = port
        self._filePath = os.path.join(cfg['arpath'], 'log')
        self._filePath = os.path.join(self._filePath, "arlog--%s.log" % time.strftime(TIME_PATTERN))
        self._logFile = open(self._filePath, 'w')
        self._sock = None
        self._workers = []
        self._running = False
        self.init_socket()
        self.start()

    def init_socket(self):
        if self._sock is None:
            try:
                self._sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                self._sock.bind((self._hostname, int(self._port)))
            except Exception, e:
                print 'err:ArTCPLogServer.init_socket(%s, %s)' % (self._hostname, self._port)
                self._sock = None
                print e

    def start(self):
        self._running = True
        while self._running:
            if self._sock:
                self._sock.listen(1)
                conn, addr = self._sock.accept()
                data = conn.recv(1024)
                if not data: continue
                if data == 'QUIT':
                    print 'ArTCPLogServer: QUIT'
                    self._running = False
                    #self._stop()
                    break
                else:# data == 'HELO':
                    self._append_log('HELO from %s\n' % addr[0])
                    monkey = ArTCPLogServerWorker(self._logFile, conn, addr)
                    monkey.start()
                    self._workers.append(monkey)
        self._close_log()
        #[monkey.join() for monkey in self._workers if monkey]
        self._sock.close()
        
    @synchronized(logfile_lock)
    def _close_log(self,):
        self._logFile.close()

    @synchronized(logfile_lock)
    def _append_log(self, msg):
        self._logFile.write("%s %s" % (time.time(),msg))


class ArTCPLogServerWorker(threading.Thread):
    ''' use this one as worker '''
    def __init__(self, logFile, conn, addr):
        self.logFile = logFile
        self.conn = conn
        self.addr = addr
        self._running = False
        threading.Thread.__init__(self)

    def run(self):
        self._running = True
        while self._running:
            data = self.conn.recv(1024)
            if not data:
                self._append_log('no data.')
                self._running = False
                continue
            self._append_log(data)
        self.logFile = None
        self.conn.close()
        return True

    @synchronized(logfile_lock)
    def _append_log(self, msg):
        self.logFile.write("%s %s" % (time.time(),msg))
        return True


class ArTCPLogClient(object):
    ''' use this one as client '''
    def __init__(self, hostname='localhost', port=4711, lazy=True):
        self._hostname = hostname
        self._port = port
        self._queue = Queue()
        if lazy: self.sock = None
        else: self.init_socket()

    def init_socket(self):
        try:
            self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            self.sock.connect((self._hostname, int(self._port)))
        except Exception, e:
            print 'err:ArTCPLogClient.init_socket(%s, %s)' % (self._hostname, self._port)
            self.sock = None            
        
    def append(self, msg, nl=True):
        if not self.sock:
            self.init_socket()
        if self.sock:
            while not self._queue.empty():
                item = self._queue.get()
                print "queue leeren: ", item
                self.sock.send(item)
            if nl:
                self.sock.send("%s%s" % (msg, '\n'))
            else:
                self.sock.send(msg)
            return True
        else:
            if nl:
                self._queue.put("%s%s" % (msg, '\n'))
            else:
                self._queue.put(msg)
            return False

    def helo(self):
        if not self.sock:
            self.init_socket()
        if self.sock:
            self.sock.send('HELO')
            return True
        return False

    def quit(self):
        if not self.sock:
            self.init_socket()
        if self.sock:
            self.sock.send('QUIT')
            return True
        return False

    def close(self):
        if self.sock:
            self.sock.close()
            return True
        return False


def serveProcess(hostname='localhost', port=4712):
    plog = Process(target=ArTCPLogServer, args=(hostname, port))
    plog.start()
    return plog

if __name__ == '__main__':
    pass
