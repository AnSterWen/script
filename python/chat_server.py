#!/usr/bin/python
import select,socket,sys,signal,cPickle,struct,argparse
SERVER_HOST = '10.1.16.65'
CHAT_SERVER_NAME = 'server'
def send(channel,*args):
    buffer = cPickle.dumps(args)
    


