#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
s = requests.Session()
s.post('http://10.1.16.65:8000/login/',data = {'username':'root','password':'123456'})
r = s.post('http://10.1.16.65:8000/altertime/',data = {'server':'test','submit':'select','time':'2015-08-18 14:57:06'})

print r.text
