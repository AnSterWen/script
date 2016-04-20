#!/usr/bin/python
# -*- coding: utf-8 -*-
import smtplib
from email.mime.text import MIMEText
from_addr = '15026479817@163.com'
password = 'zhujiangtao321'
smtp_server = 'smtp.163.com'
to_addr = '15026479817@163.com'
#to_addr = '1154377208@qq.com'
msg = MIMEText('学习zabbix','plain','utf-8')
msg['Subject'] = 'zabbix and python'
msg['From'] = from_addr
msg['To'] = to_addr
server = smtplib.SMTP(smtp_server,25)
server.set_debuglevel(1)
server.login(from_addr,password)
server.sendmail(from_addr, [to_addr], msg.as_string())
