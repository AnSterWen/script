#!/usr/bin/python
import paramiko
import sys

USER = 'rworldadmin'
PASSWORD = 'L:qAG$ji'

if len(sys.argv) < 2:
    print 'the argument must more than two'
    print "./auto_cmd.py ip1 ip2 ... 'command'"
    sys.exit(1)
elif len(sys.argv) > 2:
    COMMAND = sys.argv[-1]
else:
    pass

for ip in sys.argv[1:-1]:
    ip = ip.rstrip()
    print ip
    try:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        s.connect(hostname=ip,username=USER,password=PASSWORD)
        print COMMAND
        for i in s.exec_command(COMMAND)[1].readlines():
	    print i,
        s.close
        print '#' * 50
    except:
        print "can't connect"
        print '#' * 50
	
print 'OVER'


