#!/bin/bash
sed -n '/\[Statistics\] 16/{s/^.*] 16 //p}' 400009-debug-230000-0001 | while read line
do
    time1=$(echo $line|awk '{print $2}')
    time2=$(date -d @$time1 +"%Y-%m-%d %H:%M:%S")
    echo $line | sed -n "s/$time1/$time2/p"
done
