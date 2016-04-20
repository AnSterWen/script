#!/usr/bin/python
import math
def isprime(n):
    if n <= 1:
        return False
    for i in range(2,n):
        if n % i ==0:
            return False
    return True   
for x in range(1,100):
    if isprime(x):
        print x,
    else:
        continue
