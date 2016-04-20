#!/usr/bin/python
import MySQLdb
import sys
import subprocess

tables = ['t_ru_activity','t_ru_airank','t_ru_attribute','t_ru_base','t_ru_dailytask','t_ru_del_player','t_ru_diamondback','t_ru_dnd','t_ru_enemy','t_ru_fairy','t_ru_freeze_player','t_ru_friend','t_ru_gm','t_ru_id','t_ru_instance','t_ru_item','t_ru_kakao_cd','t_ru_kakao_friend','t_ru_lastlogin','t_ru_mail_relation','t_ru_recruit','t_ru_recruit_friend','t_ru_shared_attribute','t_ru_shopping','t_ru_skills','t_ru_task','t_ru_weapon']
for table in tables:
    for line in open('/root/id.list'):
        id_old = line.split()[0]
        id_new = line.split()[1]
        sql = "update %s set userid = 1009<<32|%s where userid = 1009<<32|%s"%(table,id_new,id_old) 
	try:
            conn=MySQLdb.connect(host='10.1.6.62',user='lush',passwd='lush',db='RU',port=3306)
            cursor=conn.cursor()
            cursor.execute(sql)
	except:
	    print table + '###################'
	    continue
        conn.close()
