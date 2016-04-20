#!/usr/bin/python
import salt.client

__outputter__ = {'www':'txt'}
def www():

    local = salt.client.LocalClient()
    ret = local.cmd('*','cmd.run',['hostname'])
    print ret
www()
#import salt.config

#opts = salt.config.client_config('/etc/salt/master')
#for i in opts:
#    print '%s ............. %s' %(i,opts[i])
