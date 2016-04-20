#!/bin/bash
TIME1=$(date --date="-1 day" "+%Y%m%d")
TIME2=$(date --date="-2 day" "+%Y%m%d")
DB_LOG="/home/rworldadmin/new_ahero/db_svc/log"
ON_LOG="/home/rworldadmin/new_ahero/online_svc/log/"

[ -d $DB_LOG ] && echo "$DB_LOG:" || exit 1
for i in $(ls $DB_LOG)
do
    if [ $i -le $TIME2 ];then
        rm -rf $DB_LOG/$i
    else
        echo "$i"
    fi
done

[ -d $ON_LOG ] && echo "$ON_LOG:" || exit 2
for i in $(ls $ON_LOG)
do
    if [ $i -le $TIME1 ];then
        rm -rf $ON_LOG/$i
    else
        echo "$i"
    fi  
done
