#!/bin/bash
#拉取全服大于多少级的用户,先写死定为60
. ./sql_config 
role_sql="SET @counter=0; replace into RU.t_ru_airank (select userid, reg_tm, zone_id, @counter:=@counter+1,log, accu_coin, accu_reputation, accu_times, accu_end_time from RU.t_ru_airank where zone_id=$1 order by rank);delete from RU.t_ru_server_attr where attribute_id= 14 and zone_id = $1;"
#mysql -uru_dbuser -pJjbfnUzP7  -P 3366 -h 192.168.24.197 -N -e "$role_sql">lose_lv
mysql -uru_dbuser -pJjbfnUzP7  -P 3306 -h 192.168.24.12 -N -e "$role_sql">lose_lv
`$SQL_CONNECT "$role_sql"`
