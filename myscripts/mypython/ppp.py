#!/usr/bin/python
name = []
for line in open('/root/b.txt'):
    name.extend(line.split())
for i in name:
    name[name.index(i)] = int(i)
print 'the max value is',max(name)
print 'the min value is',min(name)
