#!/usr/bin/awk -f
{
    i = 1
    while (i <= $2) {
        print i,NR"...php..."
	i = i + 1
	}
        
}
