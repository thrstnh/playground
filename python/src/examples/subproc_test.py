#!/usr/bin/env python

import subprocess

cmd = 'ps -o lstart="" -p 9543'
pinfo = subprocess.Popen(cmd, shell='true', stdout=subprocess.PIPE)
pstart = pinfo.stdout.read().split()
print pstart
