#!/usr/bin/awk -f

BEGIN {
    name1 = 1
    name2 = 2
    name3 = name1 + name2
    print name1 , name2,name3
}
{
    print 
}
