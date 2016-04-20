#!/usr/bin/python
import socket

HOST = '10.1.16.65'
PORT = 9999

s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
s.connect((HOST,PORT))
s.:wq
while 1:
    mess = raw_input('==>')
    s.sendall(mess)
    data = s.recv(1024)
    print 'receiced',repr(data)
    if mess == 'quit':
        break
s.close()
