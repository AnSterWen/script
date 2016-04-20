#!/usr/bin/python
#coding:utf8

import re
import sys
import os
import time
import datetime

today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
print today
now_h = (datetime.datetime.now() - datetime.timedelta(hours=1)).strftime('%H')
now_delay_m = datetime.datetime.now().strftime('%H%M%S')
if int(now_delay_m) < 2059:
    today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
    now_h = 23

print today,now_h

log_dir = ['/root/log/all_log']
data_files_dir = '/root/log/log_data'
check_dir = '/root/log/check'
log_files = []
f_files = {}
msg_file = "/root/log/bin.log"
type = 0x3

tables = ["ST_ROLE_LOGIN_INFO","ST_ROLE_LOGOUT_INFO"]

def get_log_files():
    global log_files
    file_regex = r'debug'
    file_regex_object = re.compile(file_regex)
    for dir in log_dir:
        for subdir in os.listdir(dir):
	    os.chdir(dir + '/' + subdir + '/' + today)
	    print dir + '/' + subdir + '/' + today
	    for path,dirs,files in os.walk(os.getcwd()):
	        for file in files:
	            print os.path.abspath(os.path.join(path,file))
	            if file_regex_object.search(file) and not file.endswith('swp'):
	       	        log_files.append(os.path.abspath(os.path.join(path,file)))
    print log_files

def get_f_files():  #获取文件的句柄
    global data_files_dir
    global f_files
    global tables
    try:			
        os.chdir(data_files_dir)
	for table in tables:
	    f = open(table,'w')
	    f.truncate()
	    f_files[table] = f
    except OSError:
	sys.exit(1)

def get_data_into_files():
    global log_files
    global f_files
    regex = r'\[Statistics\]'
    regexobject = re.compile(regex)
    for log_file in log_files: 
	if not os.path.exists(log_file):
	    sys.exit(1)
        f = open(log_file)
        for line in f:
            if regexobject.search(line):
                results = re.split(regex,line)
        	if results[-1].split()[0] == '12':  #用户登陆
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    login_time = time.localtime(int(L_data[2]))
        	    login_time = time.strftime("%Y-%m-%d %H:%M:%S",login_time)
		    strings = ",".join(["%s"]*8)
		    strings += '\n'
        	    if len(L_data) == 9:  
			data = (strings % (L_data[1],login_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_ROLE_LOGIN_INFO'].write(data)
        	    elif len(L_data) == 7:  
			data = (strings % (L_data[1],login_time,' ',L_data[3],L_data[4],L_data[5],L_data[6]))
			f_files['ST_ROLE_LOGIN_INFO'].write(data)
		    elif len(L_data) > 9:
			data = (strings % (L_data[1],login_time,' '.join(L_data[3:-5]),L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_ROLE_LOGIN_INFO'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "13": #用户登出
        	    if len(results[-1].split()) == 11:
		        L_data = results[-1].split()
		        try:
		            if L_data[3].index(','):
		                L_data[3] = L_data[3].replace(',','\,')
		        except ValueError:
		            pass
        		login_time = time.localtime(int(L_data[2]))
        		login_time = time.strftime("%Y-%m-%d %H:%M:%S",login_time)
        		logout_time = time.localtime(int(L_data[8]))
        		logout_time = time.strftime("%Y-%m-%d %H:%M:%S",logout_time)
			strings = ",".join(["%s"]*10)
			strings += '\n'
			data = (strings % (L_data[1],login_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],logout_time,L_data[9],L_data[10]))
			f_files['ST_ROLE_LOGOUT_INFO'].write(data)
        	    elif len(results[-1].split()) == 9:
			L_data = results[-1].split()
		        try:
		            if L_data[3].index(','):
		                L_data[3] = L_data[3].replace(',','\,')
		        except ValueError:
		            pass
        		login_time = time.localtime(int(L_data[2]))
        		login_time = time.strftime("%Y-%m-%d %H:%M:%S",login_time)
        		logout_time = time.localtime(int(L_data[7]))
        		logout_time = time.strftime("%Y-%m-%d %H:%M:%S",logout_time)
			strings = ",".join(["%s"]*9)
			strings += '\n'
			data = (strings % (L_data[1],login_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],logout_time,L_data[8],L_data[9]))
			f_files['ST_ROLE_LOGOUT_INFO'].write(data)
		    elif len(results[-1].split()) > 11:
			L_data = results[-1].split()
		        try:
		            if L_data[3].index(','):
		                L_data[3] = L_data[3].replace(',','\,')
		        except ValueError:
		            pass
        		login_time = time.localtime(int(L_data[2]))
        		login_time = time.strftime("%Y-%m-%d %H:%M:%S",login_time)
        		logout_time = time.localtime(int(L_data[-2]))
        		logout_time = time.strftime("%Y-%m-%d %H:%M:%S",logout_time)
			strings = ",".join(["%s"]*10)
			strings += '\n'
			data = (strings % (L_data[1],login_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],logout_time,L_data[-1]))
			f_files['ST_ROLE_LOGOUT_INFO'].write(data)
        	    else:
        		print results[-1].split()
        	else:
        	    pass
            else:
       	        pass 
        f.close()

def close_f_files():  #关闭文件的句柄
    global f_files
    global tables
    [f_files[table].flush() for table in tables]
    [f_files[table].close() for table in tables]

def  load_data_into_mysql():
    global data_files_dir
    try:
        os.chdir(data_files_dir)
    except OSError:
	sys.exit(1)
    for path,dirs,files in os.walk(os.getcwd()):
	for file in files:
	    cmd = "mysqlimport -i --local  -ulush -plush -h127.0.0.1  ahero %s --fields-terminated-by=','" % (os.path.abspath(os.path.join(path,file)))
	    os.system(cmd)
	    time.sleep(0.1)

if __name__ == '__main__':
    get_log_files()   	   #获取日志文件
    get_f_files()          #获取文件描述符
    get_data_into_files()  #把数据写入文件
    close_f_files()        #关闭文件描述符
    load_data_into_mysql() #把数据导入数据库
