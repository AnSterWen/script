#!/usr/bin/python
import paramiko
import sys
import getopt

PORT = 22
USER = 'root'
PASSWORD = '123456'
IP = '192.168.56.102'

def put(local,remote):
    t = paramiko.Transport((IP,PORT))
    t.connect(username=USER,password=PASSWORD)
    s = paramiko.SFTPClient.from_transport(t)
    s.put(local,remote)
    t.close

opts, args = getopt.getopt(sys.argv[1:],"hl:r:",["local=","remote="])
for opt,arg in opts:
    if opt == '-h':
        print 'sf.py -l local_file -r remotr_file'
	sys.exit()
    elif opt in ('-l','--local'):
        local = arg
    elif opt in ('-r','--remote'):
        remote = arg
put(local,remote)





