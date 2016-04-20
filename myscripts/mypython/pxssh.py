#!/usr/bin/python
import pxssh

s = pxssh.pxssh()
s.login('192.168.56.102','root','123456')
s.sendline('df -h')
s.prompt()
print s.before
s.sendline('ls -l')
s.prompt()
print s.before
