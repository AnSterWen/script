#!/usr/bin/python
import os,sys
zhu = []
jiang = {}
for line in open(sys.argv[1]):
    line = line.split(']')[1].split(';')
    zhu.append((line[0],line[1]))
for a,b in zhu:
	t = jiang.get(a,{})
	t['times'] = t.get('times',0) + 1
	t['sum'] = t.get('sum',0) + int(b)
	jiang[a] = t
print jiang

