#!/usr/bin/python
import paramiko
import multiprocessing
import sys

def cmd(IPS,WAR,USER='wls81',PASSWORD='Paic#234'):
    for IP in IPS:
        s = paramiko.SSHClient()
        s.set_missing_host_key_policy(paramiko.AutoAddPolicy())    
        s.connect(hostname=IP,username=USER,password=PASSWORD)
        s.exec_command('/wls/wls81/deploy.sh war %s' % WAR)
        s.close
        print '%s OK' %WAR

def consumer(input_q):
    while True:
        item = input_q.get()
	if item is None:
	    break
	cmd(item[1:],item[0])
	input_q.task_done()

def producer(sequence,output_q):
    for item in sequence:
        output_q.put(item)

q = multiprocessing.JoinableQueue()
cons_p1 = multiprocessing.Process(target=consumer,args=(q,))
cons_p1.daemon=True
cons_p1.start()
cons_p2 = multiprocessing.Process(target=consumer,args=(q,))
cons_p2.daemon=True
cons_p2.start()
cons_p3 = multiprocessing.Process(target=consumer,args=(q,))
cons_p3.daemon=True
cons_p3.start()
cons_p4 = multiprocessing.Process(target=consumer,args=(q,))
cons_p4.daemon=True
cons_p4.start()
cons_p5 = multiprocessing.Process(target=consumer,args=(q,))
cons_p5.daemon=True
cons_p5.start()

FILE = sys.argv[1]
sequence = []
for line in open(FILE):
    sequence.append(line.split())
producer(sequence,q)
q.join()
