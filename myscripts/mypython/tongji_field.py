#!/usr/bin/python
#对一个文件中第一个域进行统计
name = {}
for line in open('/root/a.txt'):
    if line.split()[0] in name:
        name[line.split()[0]] = int(name[line.split()[0]]) +  int(line.split()[1])
    else:
        name[line.split()[0]] = line.split()[1]

print name
