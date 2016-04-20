#!/usr/bin/python
import os
def deleteline(file1,file2):
    f1 = open(file1)
    f2 = open(file2,'w')
    for line in f1.readlines():
        if line.split():
            f2.writelines(line)
    f1.close()
    f2.close()
    os.rename(file2,file1)
deleteline('/root/mypython/backup.py','/root/mypython/backup1.py')
