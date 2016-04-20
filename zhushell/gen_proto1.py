#!/usr/bin/python
import re

pattern1 = re.compile(r'enum[\s\S]*?}')
pattern2 = re.compile(r'(\w*)\s*=')
string1 = open('world.proto').read()
string2 = pattern1.findall(string1)[0]
string3 = pattern2.findall(string2)
print string3
