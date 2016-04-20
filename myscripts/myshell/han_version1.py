#!/usr/bin/python
#-*- coding: utf-8 -*-
import paramiko
import MySQLdb
import sys
import getopt

USER = 'rworldadmin'
PASSWORD = 'L:qAG$ji'

def usage():
    '''
    print ./han.py -v [aos|ios] -l [online|online1|online2] -c [start|stop|restart|update libonline.so]
    '''
def getip(version,name):
    sql = "select server_name,ip from ip where version = '%s' and server_name = '%s'" %(version,name)
    try:
        conn = MySQLdb.connect(user='lush',passwd='lush',host='127.0.0.1',db='lush')
    except:
        print "Could not connect to MySQL server."
        sys.exit(1)
    cursor = conn.cursor()
    cursor.execute(sql)
    global result
    result = cursor.fetchall()
    cursor.close()

def cmd(ip,user,password):
    try:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        s.connect(hostname=ip,username=USER,password=PASSWORD)
        print COMMAND
        for i in s.exec_command(COMMAND)[1].readlines():
	    print i,
	s.close
        print '#' * 50
    except:
        print "can't connect"

try:
    opts,args = getopt.getopt(sys.argv[1:],'v:l:c:',['version=','list=','command='])
except getopt.GetoptError:
    usage()
    sys.exit(1)
for opt,arg in opts:
    if opt == '-h':
        usage()
        sys.exit(2)
    elif opt in ('-v','--version'):
        version = arg
    elif opt in ('-l','--list'):
        name = arg
    elif opt in ('-c','--command'):
        command = arg
    else:
        usage()
	sys.exit(4)

if version not in ['aos','ios']:
    print 'the argument after -v must be aos or ios'
    sys.exit(5)
elif name.startswith('online'):
    COMMAND = '/home/rworldadmin/lush/online.sh %s'%(command)
elif name.startswith('gateway'):
    COMMAND = '/home/rworldadmin/lush/gateway.sh %s'%(command)
elif name.startswith('db'):
    COMMAND = '/home/rworldadmin/lush/db.sh %s'%(command)
elif name.startswith('login'):
    COMMAND = '/home/rworldadmin/lush/login.sh %s'%(command)
elif name.startswith('rank'):
    COMMAND = '/home/rworldadmin/lush/rank.sh %s'%(command)
elif name.startswith('switch'):
    COMMAND = '/home/rworldadmin/lush/switch.sh %s'%(command)
else:
    pass

if name in ['online','rank','db']:
    for i in range(1,26):
        names = '%s%s'%(name,i)
	getip(version,names)
        for server_name,ip in result:
	    print '%s=============>>%s'%(server_name,ip)
            cmd(ip,USER,PASSWORD)
if name in ['gateway']:
    for i in range(1,39):
        names = '%s%s'%(name,i)
	getip(version,names)
        for server_name,ip in result:
	    print '%s=============>>%s'%(server_name,ip)
            cmd(ip,USER,PASSWORD)
elif name in ['login']:
    for i in range(1,6):
        names = '%s%s'%(name,i)
	getip(version,names)
        for server_name,ip in result:
	    print '%s=============>>%s'%(server_name,ip)
            cmd(ip,USER,PASSWORD)
else:
    getip(version,name)
    for server_name,ip in result:
        print '%s=============>>%s'%(server_name,ip)
        cmd(ip,USER,PASSWORD)


print 'OVER'
