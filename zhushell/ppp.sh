#!/bin/bash
FILE=/root/zhushell/*debug*
for i in 3 4 9 12 13 16 17 18 19 20 22 25 30 31 37 59 61 62 63 64
do
    if [ $i -eq 3 ];then
        table='ST_SUIT_INFO'
    elif [ $i -eq 4 ];then
        table='ST_SKILL_INFO'
    elif [ $i -eq 9 ];then
        table='ST_ROLE_LEVELUP'
    elif [ $i -eq 10 ];then
        table='ST_VIP_LEVELUP'
    elif [ $i -eq 11 ];then
        table='ST_UNLOCK_SPIRIT'
    elif [ $i -eq 12 ];then
        table='ST_ROLE_LOGIN_INFO'
    elif [ $i -eq 13 ];then
        table='ST_ROLE_LOGOUT_INFO'
    elif [ $i -eq 16 ];then
        table='ST_GAIN_COIN'
    elif [ $i -eq 17 ];then
        table='ST_CONSUME_COIN'
    elif [ $i -eq 18 ];then
        table='ST_GAIN_EXPLOIT'
    elif [ $i -eq 19 ];then
        table='ST_CONSUME_EXPLOIT'
    elif [ $i -eq 20 ];then
        table='ST_GAIN_PRESTIGE'
    elif [ $i -eq 22 ];then
        table='ST_STRENGTHEN_SUIT'
    elif [ $i -eq 23 ];then
        table='ST_SYNTHESIS_SUI'
    elif [ $i -eq 25 ];then
        table='ST_SKILL_LEVELUP'
    elif [ $i -eq 30 ];then
        table='ST_DAILY_TASK_INFO'
    elif [ $i -eq 31 ];then
        table='ST_TASK_RECORD'
    elif [ $i -eq 34 ];then
        table='ST_RESET_INSTANCE'
    elif [ $i -eq 35 ];then
        table='ST_GAIN_CARD'
    elif [ $i -eq 37 ];then
        table='ST_GYMKHANA'
    elif [ $i -eq 38 ];then
        table='ST_AMPHITHEATER'
    elif [ $i -eq 41 ];then
        table='ST_GAIN_GEM'
    elif [ $i -eq 42 ];then
        table='ST_RECAST_GEM'
    elif [ $i -eq 59 ];then
        table='ST_DEAD_RECORD'
    elif [ $i -eq 61 ];then
        table='ST_TASK_INFO'
    elif [ $i -eq 62 ];then
        table='ST_JOIN_INSTANCE'
    elif [ $i -eq 63 ];then
        table='ST_LEAVE_INSTANCE'
    elif [ $i -eq 64 ];then
        table='ST_COMPLETE_INSTANCE'
    elif [ $i -eq 65 ];then
        table='ST_ITEM_COMPOSE_CONSUME'
    elif [ $i -eq 66 ];then
        table='ST_ITEM_COMPOSE_GAIN'
    fi
    sed -n "/\[Statistics\] $i /{s/^.*] $i //;s/ /,/gp}" $FILE | 
    awk -F, '{s=$2;time=strftime("%Y-%m-%d %H:%M:%S",$2);gsub($2,time);print}' >>$table.txt
    mysqlimport --local --fields-terminated-by=',' ahero $table.txt&
done
