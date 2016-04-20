#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
url = 'http://10.1.16.65:8000/login/'
login_data = {'username':'root','password':'123456'}
data = urllib.urlencode(login_data)
#'http://10.1.16.65:8000/upload/'

cookie = cookielib.CookieJar()
cookieProc = urllib2.HTTPCookieProcessor(cookie)
opener = urllib2.build_opener(cookieProc)
urllib2.install_opener(opener)
urllib2.urlopen(url,data)
tt = {'server':'test','submit':'select','time':'2015-08-18 14:57:06'}
data1 = urllib.urlencode(tt)
print urllib2.urlopen('http://10.1.16.65:8000/altertime/',data1).read()
