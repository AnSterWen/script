#!/usr/bin/python
import paramiko
import multiprocessing
import sys

#工作函数
def cmd(IPS,WAR,USER='wls81',PASSWORD='Paic#234'):
    for IP in IPS:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())    
        s.connect(hostname=IP,username=USER,password=PASSWORD)
        s.exec_command('/wls/wls81/deploy.sh war %s' % WAR)
        s.close
        print '%s OK' %WAR
#消费函数
def consumer(input_q):
    while True:
        item = input_q.get()
	cmd(item[1:],item[0])
	input_q.task_done()
#生成函数
def producer(sequence,output_q):
    for item in sequence:
        output_q.put(item)
#启动进程数
q = multiprocessing.JoinableQueue()
for i in xrange(5):
    p = 'p%s' & i
    p = multiprocessing.Process(target=consumer,args=(q,))
    p.daemon=True
    p.start()
#队列元素
FILE = sys.argv[1]
sequence = []
for line in open(FILE):
    sequence.append(line.split())
producer(sequence,q)
q.join()
