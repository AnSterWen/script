#!/usr/bin/python
#coding:utf8

import re
import glob
import sys
import os
import time
import MySQLdb
import datetime

TIME = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
LOGDIR = '/root/zhushell/log/%s'%TIME
TABLES = ['ST_GAIN_COIN','ST_CONSUME_COIN']
print TIME
print LOGDIR
try:
    conn = MySQLdb.connect(user='lush',passwd='lush',host='10.1.12.50',port=3306,db='ahero')
    cursor = conn.cursor()
except:
    print 'Could not connect to MySQL server'
    sys.exit(1)

if os.path.exists(LOGDIR):
    files = glob.glob('/root/zhushell/log/20150413/*-debug-*')
else:
    print "%s does't exist"%LOGDIR
    sys.exit(1)

for file in files:
    regex = r'\[Statistics\]'
    regexobject = re.compile(regex)
    for line in open(file):
        if regexobject.search(line):
	    results = re.split(regex,line)[-1].split()
	    if results[0] == '16':
	        data = results[1:]
	        sql = '''insert into ST_GAIN_COIN values (%s,FROM_UNIXTIME(%s),'%s',%s,%s,%s,%s,%s,%s,%s)'''%(data[0],data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[8],data[9])
                cursor.execute(sql)
                
cursor.close















