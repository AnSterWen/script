#!/usr/bin/python
#-*- coding: utf-8 -*-
import xlrd

data = xlrd.open_workbook('/root/table.xlsx')
table = data.sheet_by_index(0)
for i in table.col_values(0):
    print i,
print '\n'
for i in table.col_values(1):
    print i,
