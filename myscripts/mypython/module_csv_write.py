#!/usr/bin/python
#-*- coding: utf-8 -*-
import sys
import csv 
Title = ['Name','Age','Sex'] 
Name = ['张三','李四','王二'] 
Age = ['30','20','10'] 
Sex = ['男','男','未知'] 
fileobj = open("/root/test.csv", 'wb') 
spamwriter = csv.writer(fileobj,dialect = 'excel') 
    
p1=[Name[0],Age[0],Sex[0]] 
p2=[Name[1],Age[1],Sex[1]] 
p3=[Name[2],Age[2],Sex[2]] 
spamwriter.writerow (['Name','Age','Sex']) 
spamwriter.writerow (p1) 
spamwriter.writerow (p2) 
spamwriter.writerow (p3)  
     
      
