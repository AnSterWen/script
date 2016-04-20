#!/usr/bin/python
import random
import string

def GenPasswd(length=8,chars=string.letters+string.digits):
    return ''.join([random.choice(chars) for i in range(length)])

for i in range(6):
    print GenPasswd(24)
