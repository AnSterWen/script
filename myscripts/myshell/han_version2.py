#!/usr/bin/python
#-*- coding: utf-8 -*-
import paramiko
import MySQLdb
import sys
import getopt
import os

USER = 'rworldadmin'
PASSWORD = 'L:qAG$ji'

def usage():
    '''
    print ./han.py -v [aos|ios] -l [online|online1|online2] -c [start|stop|restart|update libonline.so]
    '''
def getip(version,name):
    if name in ['online','gateway','db','login','switch','rank']:
        sql = "select server_name,ip from ip where version = '%s' and server_name like '%s%%'" %(version,name)
    else:
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
	command  = arg
    else:
        usage()
	sys.exit(4)

getip(version,name)
for server_name,ip in result:
    print '%s=============>>%s'%(server_name,ip)
    for start in ['online','gateway','db','login','switch','rank']:
        if name.startswith(start):
            if command.split()[0] in ['start','stop','restart','status','update']:
	        if command.split()[0] == 'update':
		    os.system('./put.exp %s %s'%(command.split()[1],ip))
	        COMMAND = '/home/rworldadmin/lush/%s.sh %s'%(start,command)
	    else:
	        COMMAND = command
    cmd(ip,USER,PASSWORD)
print 'OVER'
