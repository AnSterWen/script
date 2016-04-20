#!/usr/bin/python
#coding=utf-8  #字符编码
import re
import time
import sys
import MySQLdb



def create_table():
    conn=MySQLdb.connect(host='10.1.6.62',user='lush',passwd='lush',db='slowlog',port=3306)
    cursor=conn.cursor()
    cursor.execute("DROP TABLE IF EXISTS `slowlog`;")
    sql="""CREATE TABLE `slowlog` (
      `id` int(11)  unsigned NOT NULL AUTO_INCREMENT,
      `Query_time` float(11,6) NOT NULL,
      `Lock_time` char(11) NOT NULL,
      `Rows_sent` int(11) NOT NULL,
      `Rows_examined` int(11) NOT NULL,
      `time` datetime NOT NULL,
      `slow_sql` text NOT NULL,
       PRIMARY KEY (`id`),
       KEY `Query_time` (`Query_time`),
       KEY `Rows_examined` (`Rows_examined`),
       KEY `time` (`time`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"""
    cursor.execute(sql)
    conn.close()
def insert_table(log_name):
    conn=MySQLdb.connect(host='10.1.6.62',user='lush',passwd='lush',db='slowlog',port=3306)
    cursor = conn.cursor()
    for line in open(log_name):
        line=line.strip()
        Query_time=re.search('Query_time:(\s\d+\.\d+)',line) #正则匹配慢日志时间
        Lock_time=re.search('Lock_time:(\s\d+\.\d+)',line)   #正则匹配锁定时间
        Rows_sent=re.search('Rows_sent:(\s\d+)',line)    #正则匹配返回结果好多行数据
        Rows_examined=re.search('Rows_examined:(\s\d+)',line)   #正则匹配扫描好多行数据
        timestamp=re.search('timestamp=(\d+)',line)   #正则匹配时间戳
        slow_sql=re.match('(select.*?);',line)   #正则匹配慢sql
        if Query_time:
           Query_time_new=Query_time.group(1).strip()  #匹配正则结果赋值
        if Lock_time:
           Lock_time_new=Lock_time.group(1).strip()  #匹配正则结果赋值
        if Rows_sent:
           Rows_sent_new=Rows_sent.group(1).strip()  #匹配正则结果赋值
        if Rows_examined:
           Rows_examined_new=Rows_examined.group(1).strip()  #匹配正则结果赋值
        if timestamp:
           timestamp=int(timestamp.group(1))
           timeArray=time.localtime(timestamp)
           sql_time=time.strftime("%Y-%m-%d %H:%M:%S", timeArray)  #匹配正则结果赋值
        if slow_sql:
            slow_sql_new=slow_sql.group()  #匹配正则结果赋值
            set_charset="set names utf8" #设置插入字符
            sql = """INSERT INTO slowlog(Query_time,Lock_time,Rows_sent,Rows_examined,time,slow_sql)
                VALUES ("""+(Query_time_new)+""","""+Lock_time_new+""","""+(Rows_sent_new)+""","""+Rows_examined_new+""",'"""+sql_time+"""',\""""+slow_sql_new+"""\")""";
            try:
               cursor.execute(set_charset)
               cursor.execute(sql)
               conn.commit()
            except:
               conn.rollback()
    conn.close()

create_table()
insert_table('/usr/local/mysql/var/slow.log')
