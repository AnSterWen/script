#!/usr/bin/python
import multiprocessing
import os
#coding:utf8

def cmd(id):
    command = 'awk  -f online.awk %d*'%id
    os.system(command)
def consumer(input_q):
    while True:
        item = input_q.get()
	cmd(item)
	input_q.task_done()
def producer(sequence,output_q):
    for item in sequence:
        output_q.put(item)
q = multiprocessing.JoinableQueue()
for i in xrange(29):
    p = 'p%s' % i
    p = multiprocessing.Process(target=consumer,args=(q,))
    p.daemon=True
    p.start()
sequence = range(400001,400029)
producer(sequence,q)
q.join()
