#!/usr/bin/python
b = {}
f = open('/root/b.txt','w')
for line in open('/root/a.txt'):
    for i in  line.split():
        if i not in b:
            b[i] = 1
        else:
            b[i] += 1
#for x in b:
#    print >> f, '%8s\t%s' %(x,b[x])
for x in  b.iteritems():
    print x
