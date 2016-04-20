#!/usr/bin/python
import os
import multiprocessing

def worker(num,lock):
    lock.acquire()
    print num
    lock.release()
record = []
lock = multiprocessing.Lock()
for i in range(50):
    process = multiprocessing.Process(target=worker,args=(i,lock))
    process.start()
    record.append(process)
for process in record:
    process.join()
