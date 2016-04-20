#!/usr/bin/python
import urllib
import urllib2
import cookielib
import requests
headers = {
'Host':'home.51cto.com',
'Referer':'http://home.51cto.com/index.php?s=/Home/index',
'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 BIDUBrowser/7.6 Safari/537.36'
}
s = requests.Session()
s.headers.update(headers)
s.post('http://home.51cto.com/index.php?s=/Index/doLogin',data = {'email':'zhujiangtao123','passwd':'zhuzhu'})
r = s.get('http://bbs.51cto.com/api/uc.php?time=1439991984&code=f6978JS3UGki2qGkrjjoHIl5Rj4lNlZ6vEtP7DLvKNMq%2F2V%2Bs3TKdr3RjKDXEXAOKML26w6EV%2FoPonFu9JffvNg42%2BTqIRd9AKAzup6m1Ge3LAc')
print r.text
