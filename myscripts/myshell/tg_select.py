#!/usr/bin/python
#coding=utf-8  
import MySQLdb
import sys
import xlwt

result = []
file = xlwt.Workbook()
name = file.add_sheet('zhu')
for id in [1,2,3,4,5,6,7,9]:
    if id in [1,2]:
        ip = '61.91.68.92'
    elif id in [3,5]:
        ip = '61.91.68.69'
    elif id in [4,6]:
        ip = '61.91.68.98'
    elif id in [7,9]:
        ip = '61.91.68.85'
    #sql = "select zone_id,name,lv  from RU.t_ru_base where zone_id = %s order by lv desc limit 100"%id
    #sql2 = "select a.zone_id ,a.lv , a.name , b.attribute_value from RU.t_ru_base as a, RU.t_ru_attribute as b  where b.attribute_id=13 AND a.userid=b.userid AND a.reg_tm=b.reg_tm AND a.zone_id=b.zone_id and a.zone_id=%s order by b.attribute_value desc limit 100"%id
    sql2 = "select a.zone_id  , a.name , b.attribute_value from RU.t_ru_base as a, RU.t_ru_attribute as b  where b.attribute_id=13 AND a.userid=b.userid AND a.reg_tm=b.reg_tm AND a.zone_id=b.zone_id and a.zone_id=%s and  b.attribute_value >=30000 order by b.attribute_value"%id
    try:
        conn = MySQLdb.connect(user='kaka',passwd='kaka123',host=ip,db='RU')
    except:
        print "Could not connect to MySQL server."
        sys.exit(1)
    cursor = conn.cursor()
    cursor.execute('set names latin1')
    cursor.execute(sql2)
    result.extend(cursor.fetchall())
    cursor.close()
    
for j in enumerate(result):
    name.write(j[0],0,j[1][0])
    name.write(j[0],1,j[1][1].decode('utf8','ignore'))
    name.write(j[0],2,j[1][2])
file.save('/root/zhu.xls')
