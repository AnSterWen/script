#!/usr/bin/python
import fnmatch,os,os.path
files = os.listdir('/root/web')
for file in files:
    if fnmatch.fnmatch(file,'*deployed'):
        print 'OK'
    elif fnmatch.fnmatch(file,'*failed'):
        print 'FAILED'
    elif fnmatch.fnmatch(file,'*ing'):
        print 'DEPLOYING'
    elif fnmatch.fnmatch(file,'*war'):
        pass
    else:
        print 'NO'
