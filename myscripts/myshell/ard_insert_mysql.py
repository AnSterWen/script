#!/usr/bin/python
#coding:utf8

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
from email.utils import formatdate
from email.mime.text import MIMEText

#today = datetime.datetime.now().strftime('%Y%m%d') 
today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
print today
now_h = (datetime.datetime.now() - datetime.timedelta(hours=1)).strftime('%H')
now_delay_m = datetime.datetime.now().strftime('%H%M%S')
if int(now_delay_m) < 2059:
    today = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
    now_h = 23

print today,now_h

log_dir = ['/db_bak/allardonline_log']
data_files_dir = '/db_bak/ard_load_data_dir'
check_dir = '/opt/appgame/scripts/check'
log_files = []
f_files = {}
msg_file = "/opt/taomee/stat/spool/inbox/bin.log"
type = 0x3

tables = ["ST_ADD_EXP","ST_AMPHITHEATER","ST_COMPLETE_INSTANCE","ST_CONSUME_COIN","ST_CONSUME_EXPLOIT","ST_CONSUME_PSIONIC","ST_DAILY_TARGET","ST_DAILY_TASK_INFO","ST_DEAD_RECORD","ST_DOWER_LEVELUP","ST_EXCHANGE_GEM","ST_EXPLORATION_REWARD","ST_GAIN_CARD","ST_GAIN_COIN","ST_GAIN_EXPLOIT","ST_GAIN_FROM_FINDING_SPIRIT","ST_GAIN_GEM","ST_GAIN_PRESTIGE","ST_GAIN_PSIONIC","ST_GYMKHANA","ST_IMPERIAL_CITY_GUARD","ST_INLAY_GEM","ST_ITEM_COMPOSE_CONSUME","ST_ITEM_COMPOSE_GAIN","ST_JOIN_INSTANCE","ST_LEAVE_INSTANCE","ST_RECAST_GEM","ST_REFRESH_EXPLORATION","ST_REFRESH_MANOR","ST_RESET_INSTANCE","ST_REVIVING_RECORD","ST_ROLE_LEVELUP","ST_ROLE_LOGIN_INFO","ST_ROLE_LOGOUT_INFO","ST_SKILL_INFO","ST_SKILL_LEVELUP","ST_SPIRIT_INFO","ST_STRENGTHEN_SUIT","ST_SUIT_INFO","ST_SYNTHESIS_SUI","ST_TASK_INFO","ST_TASK_RECORD","ST_UNLOCK_SPIRIT","ST_VIP_LEVELUP","SC_LUCKY_OCT","ST_MULTIPEOPLE_INSTANCE","ST_RECORD_SS_EXCHANGING","ST_AUTOBATTLE","ST_MANOR_REWARD","ST_ITEM_GIAN","ST_ITEM_CONSUME","ST_LUCKY_OCT"]

logging.basicConfig(level=logging.INFO,format='[%(levelname)s] [%(asctime)s] %(message)s')


class send_mail(object):
    def __init__(self,send_to,send_title,send_txt):
        self.send_to = send_to
        self.send_title = send_title
        self.send_txt = send_txt
    def send(self):
        main_part = MIMEMultipart()
        main_part['From'] = 'jimmygong@taomee.com'
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
    file_regex = r'debug'
    file_regex_object = re.compile(file_regex)
    for dir in log_dir:
        for subdir in os.listdir(dir):
            try:
                os.chdir(dir + '/' + subdir + '/' + today)
                for path,dirs,files in os.walk(os.getcwd()):
	      		    for file in files:
		        	    print os.path.abspath(os.path.join(path,file))
	#	    if file_regex_object.search(file) and file.split('-')[2][:2] == str(now_h) and not file.endswith('swp'):
		    		    if file_regex_object.search(file) and not file.endswith('swp'):
		        		    log_files.append(os.path.abspath(os.path.join(path,file)))
	    #log_files.append(os.path.abspath(os.path.join(os.getcwd(),file)))
            except OSError:
	            logging.info('\033[01;31mAHERO:%s no such a directory\033[00m' % dir)
	            mail = send_mail('jimmygong@shoutao.com','AHERO:No such file or directory','No %s' % dir)
	            mail.send()
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
	mail = send_mail('jimmygong@taomee.com','insert_mysql.py','No %s' % data_files_dir)
	mail.send()
	sys.exit(1)

def get_data_into_files():
    global log_files
    global f_files
    regex = r'\[Statistics\]'
    regexobject = re.compile(regex)
    for log_file in log_files: 
	if not os.path.exists(log_file):
	    mail = send_mail('jimmygong@taomee.com','diamond.py','No %s' % log_file)
	    mail.send()
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
        	elif results[-1].split()[0] == "9": #角色升级
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10:
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			f_files['ST_ROLE_LEVELUP'].write(data)
        	    elif len(L_data) == 9:
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_ROLE_LEVELUP'].write(data)
		    elif len(L_data) > 9:
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_ROLE_LEVELUP'].write(data)
               	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "16": #金币产出
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
		    timestamp = int(L_data[2])
		    msg_time = time.strftime("%H:%M:%S",time.localtime(int(L_data[2])))
          	    if len(L_data) == 11:
			if L_data[6] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[6] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			f_files['ST_GAIN_COIN'].write(data)
          	    elif len(L_data) == 9:
			if L_data[5] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[5] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_GAIN_COIN'].write(data)
		    elif len(L_data) > 11:
			if L_data[-4] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[-4] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_GAIN_COIN'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "17": #金币消耗
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
		    timestamp = int(L_data[2])
		    msg_time = time.strftime("%H:%M:%S",time.localtime(int(L_data[2])))
          	    if len(L_data) == 11:
			if L_data[6] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[6] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			f_files['ST_CONSUME_COIN'].write(data)
          	    elif len(L_data) == 9:
			if L_data[5] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[5] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_CONSUME_COIN'].write(data)
		    elif len(L_data) > 11:
			if L_data[-4] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[-4] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_CONSUME_COIN'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "18": #功勋产出
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
		    timestamp = int(L_data[2])
		    msg_time = time.strftime("%H:%M:%S",time.localtime(int(L_data[2])))
         	    if len(L_data) == 11:
			if L_data[6] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[6] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			f_files['ST_GAIN_EXPLOIT'].write(data)
         	    elif len(L_data) == 9:
			if L_data[5] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[5] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_GAIN_EXPLOIT'].write(data)
		    elif len(L_data) > 11:
			if L_data[-4] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[-4] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_GAIN_EXPLOIT'].write(data)
            	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "19": #功勋消耗
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
		    timestamp = int(L_data[2])
		    msg_time = time.strftime("%H:%M:%S",time.localtime(int(L_data[2])))
        	    if len(L_data) == 11:
			if L_data[6] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[6] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[4],L_data[5],L_data[4],L_data[2],L_data[8])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			f_files['ST_CONSUME_EXPLOIT'].write(data)
        	    elif len(L_data) == 9:
			if L_data[5] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[5] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[3],L_data[4],L_data[3],L_data[2],L_data[7])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_CONSUME_EXPLOIT'].write(data)
		    elif len(L_data) > 11:
			if L_data[-4] == "1":
			    msg_data = "[%s]com.taomee.test.ahero1_1:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			elif L_data[-4] == "4":
			    msg_data = "[%s]com.taomee.test.ahero1_4:::%s_%s::::::%s:::::gian_product__count:%s:count(%s)"  %(msg_time,L_data[-6],L_data[-5],L_data[-6],L_data[2],L_data[-2])
		            msglog(msg_file, type, timestamp, msg_data)
			else:
			    pass
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_CONSUME_EXPLOIT'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "20": #声望产出
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
			f_files['ST_GAIN_PRESTIGE'].write(data)
        	    elif len(L_data) == 9:
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			f_files['ST_GAIN_PRESTIGE'].write(data)
		    elif len(L_data) > 11:
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_GAIN_PRESTIGE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "30": #每日任务数据
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12:  
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			f_files['ST_DAILY_TASK_INFO'].write(data)
        	    elif len(L_data) == 10:  
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			f_files['ST_DAILY_TASK_INFO'].write(data)
		    elif len(L_data) > 12:
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_DAILY_TASK_INFO'].write(data)
        	    else:
        	        print results[-1].split()
        	elif results[-1].split()[0] == "31": #每日任务刷新
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			f_files['ST_TASK_RECORD'].write(data)
        	    elif len(L_data) == 8: 
			data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			f_files['ST_TASK_RECORD'].write(data)
		    elif len(L_data) > 10: 
			data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			f_files['ST_TASK_RECORD'].write(data)
        	    else:
        		 print results[-1].split()
        	elif results[-1].split()[0] == "37": #竞技场
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_GYMKHANA'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_GYMKHANA'].write(data)
	 	    elif len(L_data) > 10:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_GYMKHANA'].write(data)
        	    else:
        		 print results[-1].split()
        	elif results[-1].split()[0] == "2": #精灵信息
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
			 f_files['ST_SPIRIT_INFO'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_SPIRIT_INFO'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_SPIRIT_INFO'].write(data)
        	    else:
        		 print results[-1].split()
        	elif results[-1].split()[0] == "3": #装备信息
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_SUIT_INFO'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_SUIT_INFO'].write(data)
		    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_SUIT_INFO'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "4": #技能信息
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_SKILL_INFO'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_SKILL_INFO'].write(data)
		    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_SKILL_INFO'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "61": #任务信息数据
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
			 f_files['ST_TASK_INFO'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_TASK_INFO'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_TASK_INFO'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "62": #进入副本
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
			 f_files['ST_JOIN_INSTANCE'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_JOIN_INSTANCE'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_JOIN_INSTANCE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "63": #离开副本
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_LEAVE_INSTANCE'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_LEAVE_INSTANCE'].write(data)
		    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_LEAVE_INSTANCE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "64": #完成副本
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_COMPLETE_INSTANCE'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_COMPLETE_INSTANCE'].write(data)
		    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_COMPLETE_INSTANCE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "59": #死亡记录
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
			 f_files['ST_DEAD_RECORD'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_DEAD_RECORD'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_DEAD_RECORD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "22": #装备强化
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
			 f_files['ST_STRENGTHEN_SUIT'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_STRENGTHEN_SUIT'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_STRENGTHEN_SUIT'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "25": #技能升级
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
			 f_files['ST_SKILL_LEVELUP'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_SKILL_LEVELUP'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_SKILL_LEVELUP'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "26": #天赋升级
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
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9], L_data[10]))
			 f_files['ST_DOWER_LEVELUP'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_DOWER_LEVELUP'].write(data)
		    elif len(L_data) > 11:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_DOWER_LEVELUP'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "60": #复活记录
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_REVIVING_RECORD'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_REVIVING_RECORD'].write(data)
		    elif len(L_data) > 10:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_REVIVING_RECORD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "10": #VIP升级记录
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_VIP_LEVELUP'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_VIP_LEVELUP'].write(data)
		    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_VIP_LEVELUP'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "11": #精灵解锁信息
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_UNLOCK_SPIRIT'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_UNLOCK_SPIRIT'].write(data)
		    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_UNLOCK_SPIRIT'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "23": #装备合成
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*12)
		    strings += '\n'
        	    if len(L_data) == 13: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11],L_data[12]))
			 f_files['ST_SYNTHESIS_SUI'].write(data)
        	    elif len(L_data) == 11: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			 f_files['ST_SYNTHESIS_SUI'].write(data)
        	    elif len(L_data) > 13: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-9]),L_data[-9],L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_SYNTHESIS_SUI'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "65": #兑换中物品消耗
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_ITEM_COMPOSE_CONSUME'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_ITEM_COMPOSE_CONSUME'].write(data)
        	    elif len(L_data) > 12: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_ITEM_COMPOSE_CONSUME'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "66": #兑换中物品产出
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_ITEM_COMPOSE_GAIN'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_ITEM_COMPOSE_GAIN'].write(data)
        	    elif len(L_data) > 12: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_ITEM_COMPOSE_GAIN'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "34": #副本重置
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
			 f_files['ST_RESET_INSTANCE'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_RESET_INSTANCE'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_RESET_INSTANCE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "35": #卡牌产出
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_GAIN_CARD'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_GAIN_CARD'].write(data)
        	    elif len(L_data) > 12:
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6], L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_GAIN_CARD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "38": #斗技场
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_AMPHITHEATER'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_AMPHITHEATER'].write(data)
        	    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_AMPHITHEATER'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "41": #纹章产出
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_GAIN_GEM'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_GAIN_GEM'].write(data)
        	    elif len(L_data) > 12: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_GAIN_GEM'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "42": #纹章重铸
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*13)
		    strings += '\n'
        	    if len(L_data) == 14: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11],L_data[12],L_data[13]))
			 f_files['ST_RECAST_GEM'].write(data)
        	    elif len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_RECAST_GEM'].write(data)
        	    elif len(L_data) > 14: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-10]),L_data[-10],L_data[-9],L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_RECAST_GEM'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "44": #纹章镶嵌
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*12)
		    strings += '\n'
        	    if len(L_data) == 13: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11],L_data[12]))
			 f_files['ST_INLAY_GEM'].write(data)
        	    elif len(L_data) == 11: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]))
			 f_files['ST_INLAY_GEM'].write(data)
        	    elif len(L_data) > 13: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-9]),L_data[-9],L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_INLAY_GEM'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "43": #精华消耗
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
			 f_files['ST_EXCHANGE_GEM'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_EXCHANGE_GEM'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_EXCHANGE_GEM'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "39": #王城守卫
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*8)
		    strings += '\n'
        	    if len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_IMPERIAL_CITY_GUARD'].write(data)
        	    elif len(L_data) == 7: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6]))
			 f_files['ST_IMPERIAL_CITY_GUARD'].write(data)
        	    elif len(L_data) > 9: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-5]),L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_IMPERIAL_CITY_GUARD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "67": #经验产出
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
			 f_files['ST_ADD_EXP'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_ADD_EXP'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_ADD_EXP'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "46": #庄园刷新
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_REFRESH_MANOR'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_REFRESH_MANOR'].write(data)
        	    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_REFRESH_MANOR'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "47": #云游刷新
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*8)
		    strings += '\n'
        	    if len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_REFRESH_EXPLORATION'].write(data)
        	    elif len(L_data) == 7: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6]))
			 f_files['ST_REFRESH_EXPLORATION'].write(data)
        	    elif len(L_data) > 9: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-5]),L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_REFRESH_EXPLORATION'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "49": #云游奖励
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_EXPLORATION_REWARD'].write(data)
        	    elif len(L_data) == 7: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6]))
			 f_files['ST_EXPLORATION_REWARD'].write(data)
        	    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_EXPLORATION_REWARD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "51": #寻灵产出
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
			 f_files['ST_GAIN_FROM_FINDING_SPIRIT'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_GAIN_FROM_FINDING_SPIRIT'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_GAIN_FROM_FINDING_SPIRIT'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "52": #灵能产出
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
			 f_files['ST_GAIN_PSIONIC'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_GAIN_PSIONIC'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_GAIN_PSIONIC'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "53": #灵能消耗
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_CONSUME_PSIONIC'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_CONSUME_PSIONIC'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_CONSUME_PSIONIC'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "56": #每日目标
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
			 f_files['ST_DAILY_TARGET'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_DAILY_TARGET'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_DAILY_TARGET'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "79": #运营活动
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10]),L_data[11])
			 f_files['ST_LUCKY_OCT'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_LUCKY_OCT'].write(data)
        	    elif len(L_data) > 12: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_LUCKY_OCT'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "33": #多人副本
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_MULTIPEOPLE_INSTANCE'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_MULTIPEOPLE_INSTANCE'].write(data)
        	    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_MULTIPEOPLE_INSTANCE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "54": #灵石兑换纪录
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*9)
		    strings += '\n'
        	    if len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_RECORD_SS_EXCHANGING'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_RECORD_SS_EXCHANGING'].write(data)
        	    elif len(L_data) > 10: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-6]),L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_RECORD_SS_EXCHANGING'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "69": #副本挂机
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
			 f_files['ST_AUTOBATTLE'].write(data)
        	    elif len(L_data) == 9: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8]))
			 f_files['ST_AUTOBATTLE'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_AUTOBATTLE'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "45": #庄园奖励
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
			 f_files['ST_MANOR_REWARD'].write(data)
        	    elif len(L_data) == 8: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7]))
			 f_files['ST_MANOR_REWARD'].write(data)
        	    elif len(L_data) > 11: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-7]),L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_MANOR_REWARD'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "1100": #物品产出
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*13)
		    strings += '\n'
        	    if len(L_data) == 14: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11],L_data[12],L_data[13]))
			 f_files['ST_ITEM_GIAN'].write(data)
        	    elif len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_ITEM_GIAN'].write(data)
        	    elif len(L_data) > 14: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-10]),L_data[-10],L_data[-9],L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_ITEM_GIAN'].write(data)
        	    else:
        		print results[-1].split()
        	elif results[-1].split()[0] == "1101": #物品消耗
		    L_data = results[-1].split()
		    try:
		        if L_data[3].index(','):
		            L_data[3] = L_data[3].replace(',','\,')
		    except ValueError:
		        pass
        	    the_time = time.localtime(int(L_data[2]))
        	    the_time = time.strftime("%Y-%m-%d %H:%M:%S",the_time)
		    strings = ",".join(["%s"]*11)
		    strings += '\n'
        	    if len(L_data) == 12: 
			 data = (strings % (L_data[1],the_time,L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9],L_data[10],L_data[11]))
			 f_files['ST_ITEM_CONSUME'].write(data)
        	    elif len(L_data) == 10: 
			 data = (strings % (L_data[1],the_time,' ',L_data[3],L_data[4],L_data[5],L_data[6],L_data[7],L_data[8],L_data[9]))
			 f_files['ST_ITEM_CONSUME'].write(data)
        	    elif len(L_data) > 12: 
			 data = (strings % (L_data[1],the_time,' '.join(L_data[3:-8]),L_data[-8],L_data[-7],L_data[-6],L_data[-5],L_data[-4],L_data[-3],L_data[-2],L_data[-1]))
			 f_files['ST_ITEM_CONSUME'].write(data)
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
	   cmd = "mysqlimport -i -uquery -pUplooking123 -S /var/run/mysqld/mysqld9999.sock ahero %s --fields-terminated-by=','" % (os.path.abspath(os.path.join(path,file)))
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
