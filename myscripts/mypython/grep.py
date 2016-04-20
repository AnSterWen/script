#!/usr/bin/python
import re
import paramiko
def look():
    FILE = '/opt/jboss-as-7.1.1.Final/standalone/configuration/standalone.xml'
    r = re.compile('jndi.*pool')
    for line in open(FILE):
        if r.search(line):
            print line.split()[1:3]
look()
