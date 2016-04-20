#!/usr/bin/python
import paramiko
PORT = 22
USER = 'root'
PASSWORD = '123456'
REMORE_PATH = '/tmp/qianshan.txt'
LOCAL_PATH = '/root/1.txt'
for line in open('/root/ip.txt'):
    IP = line
    t = paramiko.Transport((IP,PORT))
    t.connect(username=USER,password=PASSWORD)
    s = paramiko.SFTPClient.from_transport(t)
    s.put(LOCAL_PATH,REMORE_PATH)
    t.close
