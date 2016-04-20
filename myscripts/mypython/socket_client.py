#!/usr/bin/python
import socket
import sys
sock = socket.socket()
server_address = ('localhost',10000)
sock.connect(server_address)
try:
    for i in range(8):
        message = raw_input('>>') 
        sock.sendall(message)
        data = sock.recv(1024)
        if data:
            print data
finally:
    sock.close()
