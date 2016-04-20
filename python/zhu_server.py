#!/usr/bin/python

import socket

HOST = ''
PORT = 1000

s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
s.bind((HOST,PORT))
s.listen(5)
conn,addr = s.accept()
print 'connected by',addr
while True:
    data = conn.recv(1024)
    print data
    if not data: 
        break
    conn.sendall(data)
conn.close()
