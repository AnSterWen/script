#!/usr/bin/python
import paramiko
import sys
USER = 'root'
PASSWORD = '123456'
COMMAND = sys.argv[-1]
if len(sys.argv[1:]) < 2:
    print 'The arguments must be given more than two'
else:
    for IP in sys.argv[1:-1]:
        try:
            print IP + ':'
            s = paramiko.SSHClient()
            s.set_missing_host_key_policy(paramiko.AutoAddPolicy())    
            s.connect(hostname=IP,username=USER,password=PASSWORD)
            for i in s.exec_command(COMMAND)[1].readlines():
                print i,
            print '#'*50
            s.close
        except:
            print 'Field'
            print '#'*50
