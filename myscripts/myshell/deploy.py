#!/usr/bin/python
import paramiko
import sys
USER = 'root'
PASSWORD = '123456'


for line in open('/root/gateway_ip.list'):
    IP = line.split()[1]
    ID = line.split()[0]
    PORT = line.split()[2]
    COMMAND1 = "sed -i 's/100001/%s/g' /opt/new_ahero/gateway_svc/bind.conf" %ID
    COMMAND2 = "sed -i 's/127.0.0.1/%s/g' /opt/new_ahero/gateway_svc/bind.conf"%IP
    COMMAND3 = "sed -i 's/12000/%s/g' /opt/new_ahero/gateway_svc/bind.conf"%PORT
    print line
    try:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        s.connect(hostname=IP,username=USER,password=PASSWORD)
        s.exec_command(COMMAND1)
        s.exec_command(COMMAND2)
        s.exec_command(COMMAND3)
        s.close
        print '#' * 50
    except:
        print "can't connect"	
print 'OVER'
