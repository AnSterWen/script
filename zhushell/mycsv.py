#!/usr/bin/python
import csv
import MySQLdb

file = open('/root/zhu.csv','wb')
writer = csv.writer(file)
sql = 'select userid,reg_tm,zone_id,name  from t_ru_base limit 100'
try:
    conn = MySQLdb.connect(user='lush',passwd='lush',host='127.0.0.1',db='RU')
except:
    print "Could not connect to MySQL server."
    sys.exit(1)
cursor = conn.cursor()
cursor.execute(sql)
global result
result = cursor.fetchall()
cursor.close()

writer.writerow(('userid','reg_tm','zone_id','name'))
writer.writerows(result)
    
