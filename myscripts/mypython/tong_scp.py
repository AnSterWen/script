#!/usr/bin/python
import multiprocessing
import pexpect
import sys
import getopt


def cmd(fip,tip,war_name):
    for ip in tip:
        child = pexpect.spawn('scp -p wls81@%s:/wls/jbossersver/jboss-as-7.1.1.Final/standalone/deployments/%s wls81@%s:/wls/wls81/' %(fip,war_name,tip))
        index = child.expect(['password:','(yes/no)'])
        if index == 0:
            child.sendline('Paic#234')
        elif index == 1:
	    child.sendline('yes')
	    child.expect('password:')
	    child.sendline('Paic#234')
	index1 = child.expect(['password:','yes/no','pexpect.TIMEOUT'])
	if index1 == 0:
	    child.sendline('Paic#234')
	elif index1 == 1:
	    child.sendline('yes')
	    child.expect('password:')
	    child.sendline('Paic#234')
	elif index1 == 2:
	    sys.exit()

        child.expect(pexpect.EOF)


def consumer(input_q):
    while True:
        item = input_q.get()
	try:
	    cmd(*item)
            print '%s OK' % item
	except:
	    print '%s FAILED' % item
	input_q.task_done()

def producer(sequence,output_q):
    for item in sequence:
        output_q.put(item)


def dic(ffile,tfile):
    global fstg
    fstg = {}
    global tstg
    tstg = {}
    for line in open(ffile):
        fstg[line.split()[0]] = line.split()[1]
    for line in open(tfile):
        tstg[line.split()[0]] = line.split()[1]

def pro(n):
    global q
    q = multiprocessing.JoinableQueue()
    for i in xrange(n):
        p = 'p%s' % i
	p = multiprocessing.Process(target=consumer,args=(q,))
	p.daemon = True
	p.start()

def lst(lfile):
    global sequence
    sequence = []
    for line in open(lfile):
        war_name = line.split()[0]
	fip = fstg[war_name]
	tip = tstg[war_name]
	sequence.append([fip,tip,war_name])

try:
    opts,args = getopt.getopt(sys.argv[1:],'f:l:t:',['from=','to=','list='])

except getopt.GetoptError:
    print 'tong_scp.py -f[stg1|stg2] -t[stg1|stg2] -l[file.list]'
    sys.exit(1)

for opt,arg in opts:
    if opt == '-h':
        print 'tong_scp.py -f[stg1|stg2] -t[stg1|stg2] -l[file.list]'
	sys.exit(2)
    elif opt in ('-f','--from'):
        if arg == 'stg1':
	    ffile = '/tmp/111/war-ip-stg1.txt'
        elif arg == 'stg2':
	    ffile = '/tmp/111/war-ip-stg2.txt'
    elif opt in ('-t','--to'):
        if arg == 'stg1':
	    tfile = '/tmp/111/war-ip-stg1.txt'
	elif arg == 'stg2':
	    tfile = '/tmp/111/war-ip-stg2.txt'
    elif opt in ('-l','--list'):
        lfile = arg
    else:
        print 'tong_scp.py -f[stg1|stg2] -t[stg1|stg2] -l[file.list]'
	sys.exit(3)

pro(10)
dic(ffile,tfile)
lst(lfile)
producer(sequence,q)
a.join()
