#!/usr/bin/awk -f

BEGIN { 
    "date +%Y%m%d" | getline time
    print time
}




