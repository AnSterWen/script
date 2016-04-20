#!/usr/bin/python

import xlwt
workbook = xlwt.Workbook()
worksheet = workbook.add_sheet('sheet1')
worksheet.write(0, 0,'My Cell Contents')
worksheet.write(0, 1,'python')
worksheet.col(0).width = 8333 
workbook.save('zhu.xls')

