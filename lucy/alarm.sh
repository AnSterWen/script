#!/bin/bash
err_message1="马来正式服有core文件生成"
err_message2="马来正式服磁盘空间大于80%"
da=$(df -h | grep '/dev/hda2' | awk -F% '{print $1}' | awk '{print $5}')
db=$(df -h | grep '/dev/hdb1' | awk -F% '{print $1}' | awk '{print $5}')
ls -l /opt/shootao/appgame/online1 | grep -q core && core=1 || core=0
TEL="18621625012 15026479817 15000552911 18623313016"

send_message()
{
	for phone in $TEL
	do
        links -dump "http://114.80.98.19/cgi-bin/malaysia?mobile=$phone&msg=$1&sms_sign=aeDitai9ti3chaej5sha">/dev/null 2>&1
	done
}


if [ $core -eq 1 ];then
    send_message $err_message1
elif [ $da -ge 80 -o $db -ge 80 ];then
    send_message $err_message2
fi
