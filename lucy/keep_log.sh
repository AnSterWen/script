#!/bin/bash
TIME=$(date --date="-1 day" "+%Y%m%d")
keeplog()
{
    logdir=$1
    [ -d $1 ] && echo "$logdir" || exit 1
    for i in $(ls $logdir)
    do
        if [ $i -le $TIME ];then
            rm -rf $logdir/$i
        else
            echo "$i"
        fi
    done
}

for i in online17_svc online18_svc online19_svc online71_svc online72_svc online73_svc   db17_svc db18_svc db19_svc db71_svc  db8_svc battle17_svc battle18_svc battle19_svc battle1_svc  battle5_svc  battle6_svc  battle7_svc  battle8_svc db2_1_svc db2_2_svc db2_3_svc db2_4_svc db2_5_svc db2_6_svc
do
    log="/opt/new_ahero/$i/log"
    keeplog $log
done
