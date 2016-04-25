#!/bin/bash
TIME1=$(date "+%Y%m%d")
TIME2=$(date --date="-5 day" "+%Y%m%d")
CONN="/opt/mysql/bin/mysql -h10.144.215.79 -ukaka -pkaka123 -B -N"
#DUMP="/usr/bin/mysqldump -h10.144.215.79 -ukaka -pkaka123 --single-transaction --flush-logs --master-data=2 --databases"
DUMP="/opt/mysql/bin/mysqldump -h10.144.215.79 -ukaka -pkaka123 --databases"
DATABASES=$($CONN -e "show databases like 'db%'")
BACKDIR="/root/lush/backup_pt"
TODIR="$BACKDIR/$TIME1"

[ -d $TODIR ] || mkdir -p $TODIR
for db in $DATABASES
do
    $DUMP $db > $TODIR/$db.sql
done

/bin/gzip -qr $TODIR

for i in $(ls $BACKDIR)
do
    if [ $i -le $TIME2 ];then
    rm -rf $BACKDIR/$i
    fi
done
