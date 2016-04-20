#!/usr/bin/python
n = 100
list = range(n)
for i in range(2,n):
    for k in list[i+1:n]:
        if k%i == 0:
            list[ k ]= 0
list = [ i for i in list[2:] if i!=0 ]
print list
