#!/usr/bin/python
import fabric
from fabric.api import *
from fabric.colors import *
from fabric.context_managers import *
env.hosts = [
      '10.1.1.155',
      '10.1.1.238',
      '10.1.1.163',
] 
env.host_string = '10.1.1.155'
env.port = 22000
env.user = 'root'
env.password = 'ta0mee@123'
for cmd in ['ifconfig eth0','cd /tmp/ && pwd']:
    try:
        result = run(cmd)
        print 'result.succeeded : %s'%result.succeeded
        print 'result.failed : %s'%result.failed
    except:
        print cmd + ' failed'
