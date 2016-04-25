#!/usr/bin/python
import paramiko
import sys
USER = 'rworldadmin'
PASSWORD = 'L:qAG$ji'

def USAGE():
    print '''./check.py 'command' ip.list
             for  example:
             ./check.py '/home/rworldadmin/lush/online.sh start' onlineip.list
             ./check.py '/home/rworldadmin/lush/online.sh status' onlineip.list
             ./check.py '/home/rworldadmin/lush/online.sh restart' onlineip.list
             ./check.py "sed -i 's///g' /opt/new_ahero/online_svc/" onlineip.list'''

if sys.argv[1] == '-h':
    USAGE()
    sys.exit(0)
else:
    COMMAND = sys.argv[1]

FILE = sys.argv[-1]
for ip in open(FILE):
    ip = ip.rstrip('\n')
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
	
print 'OVER'


