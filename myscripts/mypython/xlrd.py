#!/usr/bin/python
import xlrd
data = xlrd.open_workbook('/root/1.xls')
table = data.sheets()[0]
for i in   table.col_values(1):
    print i
