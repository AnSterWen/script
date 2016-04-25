#!/bin/bash

file="/home/rworldadmin/lush/a.txt"
for ip in $(cat onlineip.txt)
do
    ./scp.exp $ip $file
	if [ $? -eq 0 ];then
	    echo "$ip OK"
	else
        echo "$ip FAILED">>/home/rworldadmin/lush/failed.txt
		continue
	fi
done
