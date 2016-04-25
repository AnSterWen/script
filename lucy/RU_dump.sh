#!/bin/bash
TIME1=$(date "+%Y%m%d")
TIME2=$(date --date="-5 day" "+%Y%m%d")
[ -d /root/lush/backup/$TIME1 ] || mkdir -p /root/lush/backup/$TIME1

/opt/mysql/bin/mysqldump -h10.45.238.176 -ukaka -pkaka123 --single-transaction --flush-logs --master-data=2 --databases RU >/root/lush/backup/$TIME1/RU.sql
gzip /root/lush/backup/$TIME1/RU.sql

for i in $(ls /root/lush/backup/)
do
    if [ $i -le $TIME2 ];then
    rm -rf /root/lush/backup/$i
    fi
done
