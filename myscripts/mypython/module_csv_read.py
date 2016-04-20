#!/usr/bin/python
#-*- coding: utf-8 -*-
import csv
import sys
with open(sys.argv[1],'rt') as f:
    reader = csv.reader(f)
    for row in reader:
        print row
	for i in row:
	    print i
