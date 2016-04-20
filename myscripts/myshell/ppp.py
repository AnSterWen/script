#!/usr/bin/python
import paramiko
import sys
import getopt


HG = {}

for line in open('/root/online_ip.list'):
    HG[line.split()[0]] = line.split()[1]

def CMD(USER,IP,PASSWORD,COMMAND):
    s = paramiko.SSHClient()
    s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    s.connect(hostname=IP,username=USER,password=PASSWORD)
    for i in s.exec_command(COMMAND)[1].readlines():
        print i,
    s.close

try:
    opts,args = getopt.getopt(sys.argv[1:],'l:c:',['list=','command='])
except getopt.GetoptError:
    print './ppp.py -l [online1|online2|...] -c [stop|start|restart]'
    sys.exit(1)
for opt,arg in opts:
    if opt == '-h':
    	print './ppp -l [online1|online2|...] -c [stop|start|restart]'
    	sys.exit(2)
    elif opt in ('-c','--command'):
        COMMAND = '/root/myexpect/online.sh %s' %arg
    elif opt in ('-l','--list'):
        if arg == 'all':
	    IPS = HG.values()
   	else:
            IPS = [HG.get(arg)]
    else:
        print './ppp.py -l [online1|online2|...] -c [stop|start|restart]'
        sys.exit(3)
USER = 'root'
PASSWORD = '123456'

for IP in IPS:
    CMD(USER,IP,PASSWORD,COMMAND)

