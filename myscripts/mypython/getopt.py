#!/usr/bin/python

import getopt
import sys
try:
    opts, args =  getopt.getopt(sys.argv[1:],'i:o:',['ifile=','ofile='])
except getopt.GetoptError:
    print 'test.py -i <inputfile> -o <outputfile>'
    sys.exit()
for opt, arg  in opts:
    if opt == '-h':
        print 'test.py -i <inputfile> -o <outputfile>'
        sys.exit()
    elif opt in ('-i','--ifile'):
	inputfile = arg
    elif opt in ('-o','--ofile'):
	outputfile = arg

print 'Input file is:', inputfile
print 'Output file is:', outputfile

















