#!/usr/bin/python
import re
# -*- coding: utf-8 -*-
fwrite = open('Cmd.txt','w')
head = ['#ifndef _CMD_H\n','#define _CMD_H\n','#include <sstream>\n','using namespace std;\n','\n','map<uint32_t, string>::value_type cmd_str_t[] = {\n']
end = [ '};\n', '\n', 'map<uint32_t, string> cmd_str(cmd_str_t, cmd_str_t+sizeof(cmd_str_t)/sizeof(map<uint32_t, string>::value_type));\n', '#endif\n', ]

name = []
newfile = 'Cmd.txt'

def gen(filename):
    pattern = re.compile(r'enum[\s\S]*?}')
    string = open(filename).read()
    lines = re.findall(pattern,string)[0].split('\n')[1:-1]
    for i in lines:
        if i != '':
            name.append(i.split()[0])
def write():
    fwrite = open(newfile,'w')
    fwrite.writelines(head)
    for i in name:
        i = 'map<uint32_t, string>::value_type(' + i +',' + '\t"' + i + '")' +',\n' 
        fwrite.write(i)
    fwrite.writelines(end)
    fwrite.close()

gen('world.proto')
write()
