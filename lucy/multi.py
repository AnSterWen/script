#!/usr/bin/python
#-*- coding: utf-8 -*-
import multiprocessing
import paramiko
import MySQLdb
import sys
import os
import getopt

USER = 'rworldadmin'
PASSWORD = 'L:qAG$ji'

def usage():
    
    print '''
    ./multi.py -v [aos|ios] -l [online|online1|gateway|switch|rank|login|db] -c [start|stop|restart|update libonline.so]
    ./multi.py -v aos -l online -c start                   #启动aos所有的online
    ./multi.py -v ios -l online -c start                   #启动ios所有的online
    ./multi.py -v aos -l online -c stop                    #停止aos所有的online
    ./multi.py -v aos -l online -c restart                 #重启aos所有的online
    ./multi.py -v aos -l online -c status                  #查看对应服务的状态
    ./multi.py -v aos -l online -c 'update libonline.so'   #更新libonline.so文件
    ./multi.py -v aos -l db -c 'update libru_db.so'        #更新libru_db.so文件
    ./multi.py -v aos -l login -c 'update liblogin.so'     #更新liblogin.so文件
    ./multi.py -v aos -l gateway -c 'update libgateway.so' #更新libgateway.so文件
    ./multi.py -v aos -l online -c '指令'                  #在所有aos的online机器上执行相同命令
    ./multi.py -v aos -l online1 -c start                  #仅对aos的online1服启动
    ./multi.py -v aos -l online -c 'ls -l /opt/new_ahero/online_svc/ | grep core' #查看是否core文件
    for i in $(seq 10 20); do ./han.py -v aos -l online$i -c status; done #部分查看
    for i in $(seq 10 20); do ./han.py -v aos -l online$i -c "echo $i"; done #传递变量
    ./multi.py -v aos -l online -c 'df -h | head -n 2'     #查看磁盘
    ./multi.py -v aos -l online -c 'uptime'                #查看负载
    /opt/new_ahero/online_svc/bench.conf                 #online配置文件
    /opt/new_ahero/online_svc/conf/ShowActivity.xml      #online配置文件
    /opt/new_ahero/online_svc/conf/ActivityCentre.xml    #online配置文件
    /opt/new_ahero/online_svc/common.conf                #online配置文件
    /opt/new_ahero/db_svc/etc/bench.conf                 #db配置文件
    /opt/new_ahero/gateway_svc/bench.conf                #gateway配置文件
    /opt/new_ahero/login_svc/bench.conf                  #login配置文件
    ./multi.py -v aos -l online -c 'md5sum /opt/new_ahero/online_svc/libonline.so'

    '''
   
def getip(version,name):
    if name in ['online','gateway','db','login','switch','rank','battle']:
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
    global sequence
    global dic
    result = cursor.fetchall()
    sequence = []
    dic = {}
    for server_name ,ip in result:
        sequence.append(ip)
	dic[ip] = server_name
    cursor.close()

def cmd(ip,user,password,command):
    for start in ['online','gateway','db','login','switch','rank','battle']:
        if name.startswith(start):
            if command.split()[0] in ['start','stop','restart','status','update']:
	        if command.split()[0] == 'update':
		    os.system('./put.exp %s %s'%(command.split()[1],ip))
	        COMMAND = '/home/rworldadmin/lush/%s.sh %s'%(start,command)
	    else:
	        COMMAND = command
    try:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        s.connect(hostname=ip,username=USER,password=PASSWORD)
        res = s.exec_command(COMMAND)[1].readlines()
	print '\033[31m%s=============>>%s\033[0m'%(dic[ip],ip)
	print COMMAND
	for i in  res:
	    print i,
        print '#' * 50
	s.close
    except:
        print "can't connect"


def consumer(input_q):
    while True:
        item = input_q.get()
	cmd(item,USER,PASSWORD,command)
	input_q.task_done()

def producer(sequence,output_q):
    for item in sequence:
        output_q.put(item)

def pro(n):
    global q
    q = multiprocessing.JoinableQueue()
    for i in xrange(n):
        p = 'p%s' % i
	p = multiprocessing.Process(target=consumer,args=(q,))
	p.daemon = True
	p.start()

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
pro(20)
producer(sequence,q)
q.join()
