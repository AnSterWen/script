#!/usr/bin/python
name = {}
list = []
for line in open('/root/a.txt'):
    name[line.split()[0]] = name.get(line.split()[0],0) + int(line.split()[1])
    list.append(line.split())
for item in name.keys():
    print '%-s:%d'%(item,name[item])
    for i in list:
        if i[0] == item:
	    print '\t%s'% i
