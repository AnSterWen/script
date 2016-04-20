#!/usr/bin/env python
#fileencoding:utf-8
URL = 'http://10.2.20.10/cgi-bin/sms.pl'
import sys
import urllib
import urllib2
import time
def sendsms(mobile,content):
    content = '[%s] %s' % (time.strftime('%Y%m%d %H:%M:%S'),content)
    data = {'mobile':mobile,'content':content}
    body = urllib.urlencode(data)
    request = urllib2.Request(URL,body)
    urldata = urllib2.urlopen(request)
    #print urldata.read()
    if __name__ == '__main__':
    sendsms(sys.argv[1],sys.argv[2])
