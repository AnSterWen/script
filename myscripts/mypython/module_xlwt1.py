#!/usr/bin/python
#-*- coding: utf-8 -*-
import xlwt
file = xlwt.Workbook(encoding='utf-8')
name1 = file.add_sheet('zhu')
name2 = file.add_sheet('jiang')
name1.write(0,0,'千山')
name1.write(0,1,'鸟飞绝')
name2.write(0,0,'学习php')
name2.write(0,1,'学习python')
file.save('/root/table.xls')





