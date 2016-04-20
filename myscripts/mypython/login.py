#!/usr/bin/python
import sys
import readline
readline.parse_and_bind('tab: complete')
n = 1
while True:
    name = raw_input('Please input your name:\n==>')   
    password = raw_input('Please input your password:\n==>')   
    if  name.lower().strip() == 'zhujiangtao' and password.lower().strip() == '123456':
        print "login successfully"
        break
    else:
        if n == 3:
            sys.exit(1)
        n += 1

