#!/usr/bin/python
#-*- coding: UTF-8 -*-
#对一个文件中第一个域进行统计
import pprint
import sys
name = {}
for line in open(sys.argv[1]):
    a = line.split()[0]
    b = line.split()[1]
    name[a] = name.get(a,0)  +  int(b)
pprint.pprint(name,depth=1,width=10)
