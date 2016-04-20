#!/usr/bin/python
import pexpect
import pxssh
import paramiko
import sys
import os

def login():
    child= pexpect.spawn('/usr/bin/ssh root@192.168.0.70')
    index = child.expect(['password:','(yes/no)'])
    if sys.argv[1] == '112':
        if index == 0:
            child.sendline('Paic#234')
	    child.expect('].*')
	    child.sendline('/root/scripts/70.py')
        else:
            child.sendline('yes')
            child.expect('password:')
            child.sendline('Paic#234')
            child.expect('].*')
            child.sendline('/root/scripts/70.py')
        child.interact()
    elif sys.argv[1] == '70':
        if index == 0:
            child.sendline('Paic#234')
        else:
            child.sendline('yes')
            child.expect('password:')
            child.sendline('Paic#234')
        child.interact()
        
    else:
        if index == 0:
	    child.sendline('Paic#234')
	    child.expect('].*')
	    child.sendline('/root/scripts/70.py')
	    child.expect('].*')
	    child.sendline('/wls/svnuser/70.py %s' % sys.argv[1])
        else:
            child.sendline('yes')
	    child.expect('password:')
	    child.sendline('Paic#234')
	    child.expect('].*')
	    child.sendline('/root/scripts/70.py')
	    child.expect('].*')
	    child.sendline('/wls/svnuser/70.py %s' % sys.argv[1])
	child.interact()


def cmd(user,ip,password,command):
    s = paramiko.SSHClient()
    s.set_missing_host_key_policy(paramiko.AutoAddPolicy())    
    s.connect(hostname=ip,username=user,password=password)
    for i in s.exec_command(command)[1].readlines():
        print i,
    



if sys.argv[1] == 'stg1':
    command = 'grep %s %s' % (sys.argv[2],'/root/scripts/war-ip-stg1.txt')
    cmd('root','192.168.0.70','Paic#234',command)
elif sys.argv[1] == 'stg2':
    command = 'grep %s %s' % (sys.argv[2],'/root/scripts/war-ip-stg2.txt')
    cmd('root','192.168.0.70','Paic#234',command)
else:
    login()
