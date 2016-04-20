#!/usr/bin/python
import paramiko
import time
USER = 'root'
PASSWORD = '123456'
COMMAND = 'ping  www.baidu.com && sleep 50'
for line in open('/root/ip.txt'):
    IP = line
    s = paramiko.SSHClient()
    s.set_missing_host_key_policy(paramiko.AutoAddPolicy())    
    s.connect(hostname=IP,username=USER,password=PASSWORD)
    s.exec_command(COMMAND)
    s.close
    print '%s OK' % line
time.sleep(60)
