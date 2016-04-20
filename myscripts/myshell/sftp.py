#!/usr/bin/python
import sys
import paramiko
import getopt
import subprocess

def SFTP(IP,PORT,USER,PASSWORD,LOCAL_PATH,REMORE_PATH):
    t = paramiko.Transport((IP,PORT))
    t.connect(username=USER,password=PASSWORD)
    s = paramiko.SFTPClient.from_transport(t)
    s.put(LOCAL_PATH,REMORE_PATH)
    t.close


def CHECK(IP,USER,PASSWORD,LFILE,RFILE):
   s = paramiko.SSHClient()
   s.set_missing_host_key_policy(paramiko.AutoAddPolicy())
   s.connect(hostname=IP,username=USER,password=PASSWORD)
   md5_r = s.exec_command('md5sum %s'%RFILE)[1].readlines()[0].split()[0]
   md5_l = subprocess.Popen('md5sum %s'%LFILE,shell=True,stdout=subprocess.PIPE).stdout.readlines()[0].split()[0]
   print 'the local  md5 is: %s\nthe remote md5 is: %s' %(md5_l,md5_r)
   if md5_r == md5_l:
       print 'UPDATE SUCCESSFULLY'
   else:
       print 'THE MD5 are DIFFERENT'

for line in open('/root/lush/HongKong.list'):
    print line
    IP = line.strip()
    FILE = sys.argv[1]
    SFTP(IP,22,'root','+KrN1pjx','/root/lush/%s'%FILE,'/root/lush/%s'%FILE)
    CHECK(IP,'root','+KrN1pjx','/root/lush/%s'%FILE,'/root/lush/%s'%FILE)
    print '#' * 50



