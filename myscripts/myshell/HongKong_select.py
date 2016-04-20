#!/usr/bin/python

import subprocess
for line in open('/root/lush/file.txt'):
    cid = line.split()[0]
    uid = line.split()[1]
    time = line.split()[2]
    command = '''mysql -ukaka -pkaka123 -h103.6.152.83 -B --skip-column-names  -e "set names latin1;select name from RU.t_ru_base where userid >> 32 = %s  and userid & 0xffffffff = %s and reg_tm = %s;"'''%(cid,uid,time)
    name = subprocess.check_output(command,shell=True)
    print '%s=====>%s'%(line.rstrip('\n'),name),
