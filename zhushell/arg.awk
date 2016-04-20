#!/usr/bin/awk -f
BEGIN {
    print "ARGC="ARGC
    for (i in ARGV)
        print "ARGV["i"]="ARGV[i]
}
