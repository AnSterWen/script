#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
#url = 'http://music.hao123.com/artist/55530'
url = 'http://pan.baidu.com/share/link?shareid=3895647262&uk=3444349763'
print urllib2.urlopen(url).read()
