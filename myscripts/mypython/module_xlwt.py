#!/usr/bin/python

import xlwt
file = xlwt.Workbook()
name = file.add_sheet('zhu')

name.write(0,0,'qian shan')
name.write(0,1,'niao fei jue')
name.write(1,0,'python')
name.write(1,1,'php')
file.save('/root/table.xls')





