# To change this template, choose Tools | Templates
# and open the template in the editor.

__author__="thrstnh"
__date__ ="$05.01.2010 19:49:31$"

import os
import re
import time
import sys

lifeline = re.compile(r"(\d) received")
report = ("No response", "Partial Response", "Alive")

print time.ctime()

for host in range(1,20):
    ip = "192.168.41."+str(host)
    pingaling = os.popen("ping -q -c2 "+ip,"r")
    print "Testing ", ip,
    sys.stdout.flush()
    while True:
        line = pingaling.readline()
        if not line: break
        igot = re.findall(lifeline, line)
        if igot:
            print report[int(igot[0])]

print time.ctime()
