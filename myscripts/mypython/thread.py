#!/usr/bin/python
#-*- encoding:UTF-8 -*-
import threading
import time

def worker(n):
    print n
    time.sleep(1)
    return

for i in range(100):
    t = threading.Thread(target=worker,args=('你好',))
    print i,
    t.start()

