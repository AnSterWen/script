#!/bin/bash
err_message="马来正式服有core文件生成"
ls -l /opt/shootao/appgame/online1 | grep -q core
if [ $? -eq 0 ];then
    for phone in "18621625012" "15026479817" "15000552911" "18623313016"
    do
        links -dump "http://114.80.98.19/cgi-bin/malaysia?mobile=$phone&msg=$err_message&sms_sign=aeDitai9ti3chaej5sha">/dev/null 2>&1
    done
else
    echo "ok"
fi
