#!/usr/bin/python
import paramiko
import sys
USER = 'wls81'
PASSWORD = 'Paic#234'

COMMAND1 = 'ls'
COMMAND2 = 'ls -l'

FILE = sys.argv[1]
for line in open(FILE):
    IPS = line.split()[1]
    print line
    for IP in IPS:
        try:
	    s = paramiko.SSHClient()
	    s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
	    s.connect(hostname=IP,username=USER,password=PASSWORD)
	    for i in s.exec_command(COMMAND1)[1].readlines():
	        print i,
	    for i in s.exec_command(COMMAND2)[1].readlines():
	        print i,
	    s.close
	    print '#' * 50
	except:
	    print "can't connect"
	
print 'OVER'


