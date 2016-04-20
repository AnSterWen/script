#!/usr/bin/python
import pexpect
user = 'root'
ip = '192.168.56.101'
password = '123456'

child = pexpect.spawn('/usr/bin/ssh %s@%s' % (user,ip))
child.expect('password:')
child.sendline(password)
child.sendline('hostname')
child.sendline('exit')
child.interact()
