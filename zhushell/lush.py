#!/usr/bin/python
#coding:utf8
import re
import sys
import os
import time
import datetime
import glob
import csv

tables = {
2:"ST_SPIRIT_INFO",
3:"ST_SUIT_INFO",
4:"ST_SKILL_INFO",
9:"ST_ROLE_LEVELUP",
10:"ST_VIP_LEVELUP", 
11:"ST_UNLOCK_SPIRIT",
12:"ST_ROLE_LOGIN_INFO",
16:"ST_GAIN_COIN",
17:"ST_CONSUME_COIN",
18:"ST_GAIN_EXPLOIT", 
19:"ST_CONSUME_EXPLOIT",
20:"ST_GAIN_PRESTIGE",
22:"ST_STRENGTHEN_SUIT",
23:"ST_SYNTHESIS_SUI",
25:"ST_SKILL_LEVELUP",
26:"ST_DOWER_LEVELUP",
30:"ST_DAILY_TASK_INFO",
31:"ST_TASK_RECORD",
33:"ST_MULTIPEOPLE_INSTANCE",
34:"ST_RESET_INSTANCE",
35:"ST_GAIN_CARD",
37:"ST_GYMKHANA",
38:"ST_AMPHITHEATER",
39:"ST_IMPERIAL_CITY_GUARD",
41:"ST_GAIN_GEM", 
42:"ST_RECAST_GEM", 
43:"ST_EXCHANGE_GEM", 
44:"ST_INLAY_GEM", 
45:"ST_MANOR_REWARD", 
46:"ST_REFRESH_MANOR", 
47:"ST_REFRESH_EXPLORATION", 
49:"ST_EXPLORATION_REWARD", 
51:"ST_GAIN_FROM_FINDING_SPIRIT", 
52:"ST_GAIN_PSIONIC", 
53:"ST_CONSUME_PSIONIC", 
54:"ST_RECORD_SS_EXCHANGING", 
56:"ST_DAILY_TARGET", 
59:"ST_DEAD_RECORD", 
60:"ST_REVIVING_RECORD", 
61:"ST_TASK_INFO", 
62:"ST_JOIN_INSTANCE", 
63:"ST_LEAVE_INSTANCE", 
64:"ST_COMPLETE_INSTANCE", 
65:"ST_ITEM_COMPOSE_CONSUME", 
66:"ST_ITEM_COMPOSE_GAIN", 
67:"ST_ADD_EXP", 
69:"ST_AUTOBATTLE", 
79:"ST_LUCKY_OCT", 
1100:"ST_ITEM_GIAN", 
1101:"ST_ITEM_CONSUME"
}
TIME = (datetime.datetime.now() - datetime.timedelta(days=1)).strftime('%Y%m%d')
dir = '/root/zhushell/%s'%TIME
logdir = '%s/*-debug-*'%dir
if os.path.exists(dir):
    logfiles = glob.glob(logdir)
else:
    print "%s does't exist"%dir
    sys.exit(1)
myfile = {}
for file in tables.values():
    f = open(file,'w')
    writer = csv.writer(f)
    myfile[file] = writer
regex = r'\[Statistics\]'
regexobject = re.compile(regex)
for logfile in logfiles: 
    for line in open(logfile):
        if regexobject.search(line):
            results = re.split(regex,line)
	    numberid = int(results[-1].split()[0])
      	    if numberid in tables.keys():
		data = results[-1].split()[1:]
		data[1] = time.strftime('%Y-%m-%d %H:%M:%S',time.gmtime(int(data[1])))
                myfile[tables[numberid]].writerow(data)
#os.system("mysqlimport --local --fields-terminated-by=',' ahero ST_*")
