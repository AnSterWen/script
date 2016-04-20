#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
s = requests.Session()
s.post('http://10.1.16.65:8000/login/',data = {'username':'root','password':'123456'})
f = open('ppp.txt')
r = s.post('http://10.1.16.65:8000/upload/',data = {'server':'test'},files={'file':f})

print r.text
