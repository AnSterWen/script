#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
url = 'https://mail.qq.com/cgi-bin/loginpage'
print urllib2.urlopen(url).read()
