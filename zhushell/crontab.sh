#!/bin/bash
DATE=$(grep gengxin /var/spool/cron/crontabs/root | awk '{print $3}')
MONTH=$(grep gengxin /var/spool/cron/crontabs/root | awk '{print $4}')
DATE1=$1
MONTH1=$2
sed -i "/gengxin/{s/$DATE/$DATE1/g;s/$MONTH/$MONTH1/g}" /var/spool/cron/crontabs/root
