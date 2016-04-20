#!/usr/bin/awk -f
{
if ($2 >4)
    print "....php..."
else 
    print "@@@@mysql@@@@"
}
