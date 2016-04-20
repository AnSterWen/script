#!/usr/bin/python
#coding: utf8
#
# "AHERO 日志收集"

import re
import sys
import os
import time
import MySQLdb
import datetime
import logging
import struct
import stat
import smtplib
from email.mime.multipart import MIMEMultipart
#from email.MIMEMultipart import MIMEMultipart
from email.utils import formatdate
#from email.Utils import formatdate
from email.MIMEText import MIMEText

#today = datetime.datetime.now().strftime('%Y%m%d')
today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
print today
now_h = (datetime.datetime.now() - datetime.timedelta(hours=1)).strftime('%H')
now_delay_m = datetime.datetime.now().strftime('%H%M%S')
if int(now_delay_m) < 2059:
    today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
    now_h = 23

print today,now_h

log_dir = ['/root/log/all_log/']
data_files_dir = '/root/log/log_data'
check_dir = '/root/log/check'
log_files = []
f_files = {}
msg_file = "/root/log/bin.log"
type = 0x3

tables = ["ST_CONSUME_DIAMOND","ST_GAIN_DIAMOND"]

logging.basicConfig(level=logging.INFO,format='[%(levelname)s] [%(asctime)s] %(message)s')


class send_mail(object):
    def __init__(self,send_to,send_title,send_txt):
        self.send_to = send_to
        self.send_title = send_title
        self.send_txt = send_txt
    def send(self):
        main_part = MIMEMultipart()
        main_part['From'] = 'lygame@taomee.com'
        main_part['To'] = self.send_to
        main_part['Subject'] = "%s"%(self.send_title)
        main_part['Date'] = formatdate()
        if self.send_txt:
            txt = "<font color=red size=2>%s</font><br/><br/>" % self.send_txt
            html_txt = MIMEText("%s"%txt , _subtype='html' , _charset='utf-8')
            main_part.attach(html_txt)
            fulltext = main_part.as_string()
            try:
                smtp = smtplib.SMTP()
                smtp.connect('192.168.6.8')
                smtp.sendmail(main_part['From'],self.send_to,fulltext)
                smtp.quit()
            except:
                logging.info('smtp connect failed')

def get_log_files():
    global log_files
    file_regex = r'fatal'
    file_regex_object = re.compile(file_regex)
    for dir in log_dir:
        for subdir in os.listdir(dir):
            try:
	        os.chdir(dir + '/' + subdir + '/' + today)
	        for path,dirs,files in os.walk(os.getcwd()):
		    for file in files:
		        print os.path.abspath(os.path.join(path,file))
#		    if file_regex_object.search(file) and file.split('-')[2][:2] == str(now_h) and not file.endswith('swp'):
		        if file_regex_object.search(file) and not file.endswith('swp'):
		   	    log_files.append(os.path.abspath(os.path.join(path,file)))
	    #log_files.append(os.path.abspath(os.path.join(os.getcwd(),file)))
            except OSError:
	        logging.info('\033[01;31mAHERO:%s no such a directory\033[00m' % dir)
	       # mail = send_mail('jimmygong@shootao.com','AHERO:No such file or directory','No %s' % dir)
	       # mail.send()
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
	mail = send_mail('jimmygong@shootao.com','insert_mysql.py','No %s' % data_files_dir)
	mail.send()
	sys.exit(1)

def get_data_into_files():
    global log_files
    global f_files
    regex = r'\[Statistics\]'
    regexobject = re.compile(regex)
    for log_file in log_files: 
	if not os.path.exists(log_file):
	    mail = send_mail('jimmygong@shootao.com','diamond.py','No %s' % log_file)
	    mail.send()
	    sys.exit(1)
        f = open(log_file)
        for line in f:
            if regexobject.search(line):
                results = re.split(regex,line)
        	if results[-1].split()[0] == '14':  #钻石获得
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*10)
		    strings += '\n'
        	    if len(L_data) == 11:
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7], L_data[8], L_data[9], L_data[10]))
			f_files['ST_GAIN_DIAMOND'].write(data)
        	    elif len(L_data) == 10:  
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			f_files['ST_GAIN_DIAMOND'].write(data)
		    elif len(L_data) > 11:
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_GAIN_DIAMOND'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "15": #钻石消耗
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*10)
		    strings += '\n'
        	    if len(L_data) == 11: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			 f_files['ST_CONSUME_DIAMOND'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_CONSUME_DIAMOND'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_CONSUME_DIAMOND'].write(data)
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
	mail = send_mail('jimmygong@shootao.com','insert_mysql.py','No %s' % data_files_dir)
	mail.send()
	sys.exit(1)
    for path,dirs,files in os.walk(os.getcwd()):
	for file in files:
	    cmd = "mysqlimport -i --local -upubs_ru_mng -p0EOxMx=9@cWO  -h103.6.152.83  ahero1 %s --fields-terminated-by=','" % (os.path.abspath(os.path.join(path,file)))
	    print(cmd);
	    os.system(cmd)
	    time.sleep(0.1)

def judge_rsync():   #判断rsync是否同步完全
    try:
        os.chdir(check_dir)
	txt = "%s.txt" % (today+str(now_h))
	os.stat(os.path.abspath(os.path.join(os.getcwd(),txt)))
    except OSError:
	mail = send_mail('jimmygong@shootao.com','insert_mysql.py','Rsync Failed!!')
	mail.send()
	sys.exit(1)
  
def msglog(logfile, type, timestamp, data):
    if len(data) == 0:
        return 0
    hlen = 24;
    msg_len = hlen + len(data)
   #print "msg_len:", msg_len, "type:", type, "timestamp:", timestamp
    '''
    struct message_header {
	        uint16_t len;
	        unsigned char  hlen;                                      
	        unsigned char  flag0;                                     
	        uint32_t  flag;
	        uint32_t  saddr;                                          
	        uint32_t  seqno;                                          
	        uint32_t  type; 
	        uint32_t  timestamp;                                      
    };
    '''
    #head
    bytes = struct.pack('hbb5i', msg_len, hlen, 0, 0, 0, 0, type, timestamp)

    #body
    for count in data:
        bytes += struct.pack('c', count)
    try:
       #print bytes
        output = open(logfile, "ab+")
	output.write(bytes)
	output.close()
    except:
        logtime = time.strftime('%Y-%m-%d %H:%M:%S', time.localtime(time.time()))
        print logtime
        print sys.exc_info()[0],  sys.exc_info()[1]
        print ""
        return -1
    try:
        os.chmod(logfile,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
    except OSError:
	pass

if __name__ == '__main__':
    #judge_rsync()          #判断rsync是否同步完全
    get_log_files()   	   #获取日志文件
    get_f_files()          #获取文件描述符
    get_data_into_files()  #把数据写入文件
    close_f_files()        #关闭文件描述符
    load_data_into_mysql() #把数据导入数据库
