#!/usr/bin/python
import subprocess
import re
regu = re.compile('\\d+\.\\d+\.\\d+\.\\d+')
p = subprocess.Popen('ifconfig eth0',shell=True,stdout=subprocess.PIPE)
print regu.findall(p.stdout.read())[0]
