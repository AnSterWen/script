#!/bin/bash
#不跨mysql合服脚本
CONNECT="mysql -ukaka -pkaka123 -h127.0.0.1 -B -N -e" #连接mysql指令
FORM_ID="3 5"                                         #指定被合服的id
ZONE_EXP="zone_id=3 or zone_id = 5"
TO_ID=100                                             #合服后的id
TABLES=$($CONNECT "show tables from RU")
role_sql="SET @counter=0; replace into RU.t_ru_airank (select userid, reg_tm, zone_id, @counter:=@counter+1,log, accu_coin, accu_reputation, accu_times, accu_end_time from RU.t_ru_airank where zone_id=$TO_ID order by rank);delete from RU.t_ru_server_attr where attribute_id= 14 and zone_id = $TO_ID"
#修改角色名
for id in $FORM_ID
do
    $CONNECT  "update RU.t_ru_base set name=concat(name,'-s$id') where zone_id=$id and name not like '%-s%'"
done

#修改服务id
for table in $TABLES
do
    echo $table
    $CONNECT "update RU.$table set zone_id=if($ZONE_EXP,$TO_ID,zone_id)"
done
#rank排序
$CONNECT "$role_sql"

