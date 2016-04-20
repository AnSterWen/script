#!/usr/bin/python
#-*- coding: utf-8 -*-
import xlrd

#data = xlrd.open_workbook('/root/table.xlsx')
data = xlrd.open_workbook('/root/table.xlsx')
table = data.sheet_by_index(0)
for i in range(table.nrows):
    print i 
