#!/usr/bin/python
import paramiko
import sys
import os
PORT = 22
USER = 'root'
PASSWORD = '123456'
IP = '192.168.56.102'
REMORE_PATH = sys.argv[2]
LOCAL_PATH = sys.argv[1]
t = paramiko.Transport((IP,PORT))
t.connect(username=USER,password=PASSWORD)
s = paramiko.SFTPClient.from_transport(t)
if os.path.exists(LOCAL_PATH):
    s.put(LOCAL_PATH,REMORE_PATH)
else:
    s.get(REMORE_PATH,LOCAL_PATH)
t.close
