#!/usr/bin/python
#-*- coding: UTF-8 -*-
#对一个文件中第一个域进行统计
import pprint
import sys
name = {}
for line in open(sys.argv[1]):
    if line.split()[0] in name:
        name[line.split()[0]] = int(name[line.split()[0]]) +  int(line.split()[1])
    else:
        name[line.split()[0]] = line.split()[1]

pprint.pprint(name,depth=1,width=10)
